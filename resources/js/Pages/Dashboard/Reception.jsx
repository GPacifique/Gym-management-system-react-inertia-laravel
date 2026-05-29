import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { usePage, Link } from "@inertiajs/react";
import DashboardCharts from "@/Components/GymCharts";

export default function Reception() {
    const {
        auth,
        stats,
        recentActivities = [],
    } = usePage().props;

    const user = auth.user;

    return (
        <DashboardLayout user={user}>
            <div className="space-y-6">

                {/* HEADER */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-800">
                            Reception Dashboard
                        </h1>

                        <p className="text-gray-500 mt-1">
                            Welcome back, {user.name}
                        </p>
                    </div>

                    <div>
                        <span className="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-sm font-medium">
                            Reception Active
                        </span>
                    </div>
                </div>

                {/* STATS CARDS */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div className="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                        <h2 className="text-gray-500">
                            New Members
                        </h2>

                        <p className="text-3xl font-bold mt-2">
                            {stats?.new_members ?? 0}
                        </p>
                    </div>

                    <div className="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                        <h2 className="text-gray-500">
                            Today's Check-ins
                        </h2>

                        <p className="text-3xl font-bold mt-2">
                            {stats?.today_checkins ?? 0}
                        </p>
                    </div>

                    <div className="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                        <h2 className="text-gray-500">
                            Pending Payments
                        </h2>

                        <p className="text-3xl font-bold mt-2">
                            {stats?.pending_payments ?? 0}
                        </p>
                    </div>

                </div>

                {/* QUICK ACTIONS */}
                <div className="bg-white p-6 rounded-2xl shadow">

                    <div className="flex items-center justify-between mb-5">
                        <h2 className="text-xl font-semibold">
                            Quick Actions
                        </h2>

                        <p className="text-sm text-gray-500">
                            Reception operations shortcuts
                        </p>
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                        {/* ADD MEMBER */}
                        <Link
                            href={route("members.create")}
                            className="bg-blue-600 hover:bg-blue-700 transition text-white p-5 rounded-2xl shadow"
                        >
                            <h3 className="font-bold text-lg">
                                Add Member
                            </h3>

                            <p className="text-sm mt-2 opacity-90">
                                Register a new gym member
                            </p>
                        </Link>

                        {/* RECORD ATTENDANCE */}
                        <Link
                            href={route("attendance.index")}
                            className="bg-green-600 hover:bg-green-700 transition text-white p-5 rounded-2xl shadow"
                        >
                            <h3 className="font-bold text-lg">
                                Record Attendance
                            </h3>

                            <p className="text-sm mt-2 opacity-90">
                                Manage member check-ins
                            </p>
                        </Link>

                        {/* BOOKINGS */}
                        <Link
                            href={route("bookings.index")}
                            className="bg-yellow-500 hover:bg-yellow-600 transition text-white p-5 rounded-2xl shadow"
                        >
                            <h3 className="font-bold text-lg">
                                View Bookings
                            </h3>

                            <p className="text-sm mt-2 opacity-90">
                                Sauna, pool & facility bookings
                            </p>
                        </Link>

                        {/* PAYMENTS */}
                        <Link
                            href={route("payments.index")}
                            className="bg-red-500 hover:bg-red-600 transition text-white p-5 rounded-2xl shadow"
                        >
                            <h3 className="font-bold text-lg">
                                Payments
                            </h3>

                            <p className="text-sm mt-2 opacity-90">
                                Handle subscriptions & invoices
                            </p>
                        </Link>

                    </div>

                </div>

                {/* RECENT ACTIVITY */}
                <div className="bg-white p-6 rounded-2xl shadow">

                    <div className="flex items-center justify-between mb-5">

                        <h2 className="text-xl font-semibold">
                            Recent Reception Activity
                        </h2>

                        <Link
                            href={route("activities.index")}
                            className="text-blue-600 hover:underline text-sm"
                        >
                            View All
                        </Link>

                    </div>

                    <div className="overflow-x-auto">

                        <table className="w-full border-collapse">

                            <thead>
                                <tr className="bg-gray-100 text-left">
                                    <th className="p-3">Member</th>
                                    <th className="p-3">Action</th>
                                    <th className="p-3">Time</th>
                                    <th className="p-3">Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                {recentActivities.length > 0 ? (
                                    recentActivities.map((activity) => (
                                        <tr
                                            key={activity.id}
                                            className="border-b"
                                        >
                                            <td className="p-3">
                                                {activity.member_name}
                                            </td>

                                            <td className="p-3">
                                                {activity.action}
                                            </td>

                                            <td className="p-3">
                                                {activity.time}
                                            </td>

                                            <td className="p-3">
                                                <span
                                                    className={`px-3 py-1 rounded-full text-sm
                                                        ${
                                                            activity.status === "Completed"
                                                                ? "bg-green-100 text-green-700"
                                                                : "bg-yellow-100 text-yellow-700"
                                                        }`}
                                                >
                                                    {activity.status}
                                                </span>
                                            </td>
                                        </tr>
                                    ))
                                ) : (
                                    <tr>
                                        <td
                                            colSpan="4"
                                            className="p-6 text-center text-gray-500"
                                        >
                                            No recent activities found.
                                        </td>
                                    </tr>
                                )}

                            </tbody>

                        </table>

                    </div>

                </div>

                {/* CHARTS */}
                <DashboardCharts />

            </div>
        </DashboardLayout>
    );
}