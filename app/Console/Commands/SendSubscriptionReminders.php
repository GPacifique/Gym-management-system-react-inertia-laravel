<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MemberSubscription;
use App\Models\MemberNotification;
use App\Services\SmsService;
Use App\Services\TwilioService;
use Carbon\Carbon;

class SendSubscriptionReminders extends Command
{
    /**
     * Command signature.
     */
    protected $signature = 'subscriptions:send-reminders';

    /**
     * Command description.
     */
    protected $description = 'Send SMS reminders for expiring subscriptions';

    /**
     * Execute the command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $subscriptions = MemberSubscription::with([
            'member',
            'plan'
        ])
        ->where('status', 'active')
        ->get();

        foreach ($subscriptions as $subscription) {

            if (!$subscription->member) {
                continue;
            }

            $daysRemaining = $today->diffInDays(
                Carbon::parse($subscription->end_date),
                false
            );

            if (!in_array($daysRemaining, [7, 3, 1])) {
                continue;
            }

            $member = $subscription->member;

            $message = sprintf(
                "Hello %s, your gym subscription (%s) will expire in %d day(s). Please renew before %s.",
                $member->first_name ?? $member->name,
                $subscription->plan?->name ?? 'Membership Plan',
                $daysRemaining,
                Carbon::parse($subscription->end_date)->format('d M Y')
            );

            /*
            |--------------------------------------------------------------------------
            | Prevent duplicate reminders
            |--------------------------------------------------------------------------
            */
            $alreadySent = MemberNotification::where('member_id', $member->id)
                ->where('type', 'sms')
                ->whereDate('created_at', today())
                ->where('message', $message)
                ->exists();

            if ($alreadySent) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Save notification
            |--------------------------------------------------------------------------
            */
            MemberNotification::create([
                'member_id' => $member->id,
                'title' => 'Subscription Expiry Reminder',
                'message' => $message,
                'type' => 'sms',
                'sent_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Send SMS
            |--------------------------------------------------------------------------
            */
            if (!empty($member->phone)) {

                SmsService::send(
                    $member->phone,
                    $message
                );
            }

            $this->info(
                "Reminder sent to Member #{$member->id}"
            );
        }

        $this->info('Subscription reminders completed.');

        return Command::SUCCESS;
    }
}