import { Link } from "@inertiajs/react";

export default function QuickActions() {
    return (
        <div className="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">

            <Link
                href="/member-subscriptions/create"
                className="bg-green-600 text-white p-3 rounded shadow text-center"
            >
                ➕ Assign Subscription
            </Link>

            <Link
                href="/payments/create"
                className="bg-blue-600 text-white p-3 rounded shadow text-center"
            >
                💳 Record Payment
            </Link>

            <Link
                href="/membership-plans"
                className="bg-purple-600 text-white p-3 rounded shadow text-center"
            >
                📋 Membership Plans
            </Link>

            <Link
                href="/receipts"
                className="bg-gray-800 text-white p-3 rounded shadow text-center"
            >
                🧾 Receipts
            </Link>

        </div>
    );
}