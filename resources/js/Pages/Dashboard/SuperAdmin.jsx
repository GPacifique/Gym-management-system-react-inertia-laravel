import React from "react";
import { Link, usePage } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function SuperAdmin() {
    const { stats, recentActivities } = usePage().props;

    const cards = [
        {
            title: "Total Gyms",
            value: stats?.totalGyms ?? 0,
            icon: "🏢",
            color: "bg-blue-500",
        },
        {
            title: "Total Members",
            value: stats?.totalMembers ?? 0,
            icon: "👥",
            color: "bg-green-500",
        },
        {
            title: "Total Trainers",
            value: stats?.totalTrainers ?? 0,
            icon: "💪",
            color: "bg-purple-500",
        },
        {
            title: "Monthly Revenue",
            value: `$${stats?.monthlyRevenue ?? 0}`,
            icon: "💰",
            color: "bg-yellow-500",
        },
        {
            title: "Active Subscriptions",
            value: stats?.activeSubscriptions ?? 0,
            icon: "📦",
            color: "bg-pink-500",
        },
        {
            title: "Pending Payments",
            value: stats?.pendingPayments ?? 0,
            icon: "🧾",
            color: "bg-red-500",
        },
    ];

    return (
        <DashboardLayout>
            <div className="min-h-screen bg-gray-100 p-6">

                {/* HEADER */}
                <div className="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

                    <div>
                        <h1 className="text-4xl font-bold text-gray-800">
                            Super Admin Dashboard
                        </h1>

                        <p className="text-gray-500 mt-2">
                            Real-time platform analytics and system control.
                        </p>
                    </div>

                    <div className="mt-4 md:mt-0 flex gap-3">

                        <Link
                            href={route('superadmin.gyms.create')}
                            className="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow"
                        >
                            Add Gym
                        </Link>

                        <Link
                            href="/reports"
                            className="bg-gray-900 hover:bg-black text-white px-5 py-3 rounded-xl shadow"
                        >
                            Generate Report
                        </Link>

                    </div>
                </div>

                {/* STATS */}
                <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">

                    {cards.map((stat, index) => (
                        <div
                            key={index}
                            className="bg-white rounded-2xl shadow-md p-6 flex items-center justify-between"
                        >
                            <div>
                                <p className="text-gray-500 text-sm">
                                    {stat.title}
                                </p>

                                <h2 className="text-3xl font-bold mt-2 text-gray-800">
                                    {stat.value}
                                </h2>
                            </div>

                            <div
                                className={`${stat.color} w-16 h-16 rounded-2xl flex items-center justify-center text-3xl text-white shadow`}
                            >
                                {stat.icon}
                            </div>
                        </div>
                    ))}

                </div>

                {/* MAIN GRID */}
                <div className="grid grid-cols-1 xl:grid-cols-3 gap-6">

                    {/* RECENT ACTIVITIES */}
                    <div className="xl:col-span-2 bg-white rounded-2xl shadow-md p-6">

                        <div className="flex items-center justify-between mb-6">
                            <h2 className="text-2xl font-bold text-gray-800">
                                Recent Activities
                            </h2>

                            <button className="text-blue-600 hover:underline">
                                View All
                            </button>
                        </div>

                        <div className="space-y-4">
                            {recentActivities?.map((activity, index) => (
                                <div
                                    key={index}
                                    className="border border-gray-100 rounded-xl p-4 hover:bg-gray-50 transition"
                                >
                                    <p className="text-gray-700">
                                        {activity}
                                    </p>
                                </div>
                            ))}
                        </div>

                    </div>

                    {/* QUICK ACTIONS */}
                    <div className="bg-white rounded-2xl shadow-md p-6">

                        <h2 className="text-2xl font-bold text-gray-800 mb-6">
                            Quick Actions
                        </h2>

                        <div className="space-y-4">

                            <Link
                                href={route('superadmin.gyms.create')}
                                className="block text-center w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition"
                            >
                                Create New Gym
                            </Link>

                            <Link
                                href="/trainers/create"
                                className="block text-center w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl transition"
                            >
                                Add Trainer
                            </Link>

                            <Link
                                href="/analytics"
                                className="block text-center w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-xl transition"
                            >
                                View Analytics
                            </Link>

                            <Link
                                href="/payments"
                                className="block text-center w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl transition"
                            >
                                Manage Payments
                            </Link>

                            <Link
                                href="/settings"
                                className="block text-center w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl transition"
                            >
                                System Settings
                            </Link>

                        </div>

                    </div>

                </div>

                {/* FOOTER */}
                <div className="mt-10 text-center text-gray-400 text-sm">
                    Gym SaaS Platform • Super Admin Panel
                </div>

            </div>
        </DashboardLayout>
    );
}