<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MemberSubscription;
use App\Services\SmsService;
use Carbon\Carbon;

class ProcessSubscriptionExpiry extends Command
{
    protected $signature = 'subscriptions:process-expiry';

    protected $description = 'Expire subscriptions and send SMS reminders';

    public function handle()
    {
        $today = Carbon::today();

        $subscriptions = MemberSubscription::with('member')
            ->where('status', 'active')
            ->get();

        foreach ($subscriptions as $subscription) {

            $daysRemaining = $today->diffInDays(
                $subscription->end_date,
                false
            );

            /**
             * 1. AUTO EXPIRE
             */
            if ($daysRemaining < 0) {

                $subscription->update([
                    'status' => 'expired',
                ]);

                // Send expired SMS
                SmsService::send(
                    $subscription->member->phone,
                    "Your gym membership has expired. Please renew to continue accessing services."
                );

                continue;
            }

            /**
             * 2. REMINDER SMS
             */
            if (in_array($daysRemaining, [7, 3, 1])) {

                SmsService::send(
                    $subscription->member->phone,
                    "Reminder: Your gym membership expires in {$daysRemaining} day(s). Please renew in time."
                );
            }
        }

        $this->info('Subscription expiry processing completed successfully.');
    }
}