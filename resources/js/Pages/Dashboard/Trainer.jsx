import React from "react";
import { Head, Link } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";
import Footer from "@/Components/Footer";

export default function Dashboard({
    trainer,
    stats,
    recentClients = [],
    upcomingSessions = [],
}) {
    return (
        <>
        <DashboardLayout>
            <Head title="Trainer Dashboard" />

            <div className="min-h-screen bg-gray-50 p-6">
                <div className="mx-auto max-w-7xl">

                    {/* Header */}
                    <div className="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 className="text-3xl font-bold text-gray-900">
                                Welcome, {trainer?.name}
                            </h1>

                            <p className="mt-2 text-gray-600">
                                Manage your members, sessions, and earnings.
                            </p>
                        </div>

                        <div className="mt-4 md:mt-0">
                            <Link
                                href={route("trainer.members.create")}
                                className="rounded-lg bg-indigo-600 px-5 py-3 text-white hover:bg-indigo-700"
                            >
                                Add New Member
                            </Link>
                        </div>
                    </div>

                    {/* Stats */}
                    <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-4">

                        <div className="rounded-xl bg-white p-6 shadow-sm">
                            <h3 className="text-sm font-medium text-gray-500">
                                Total Members
                            </h3>

                            <p className="mt-2 text-3xl font-bold text-gray-900">
                                {stats.total_members}
                            </p>
                        </div>

                        <div className="rounded-xl bg-white p-6 shadow-sm">
                            <h3 className="text-sm font-medium text-gray-500">
                                Active Members
                            </h3>

                            <p className="mt-2 text-3xl font-bold text-green-600">
                                {stats.active_members}
                            </p>
                        </div>

                        <div className="rounded-xl bg-white p-6 shadow-sm">
                            <h3 className="text-sm font-medium text-gray-500">
                                Monthly Earnings
                            </h3>

                            <p className="mt-2 text-3xl font-bold text-blue-600">
                                ${stats.monthly_earnings}
                            </p>
                        </div>

                        <div className="rounded-xl bg-white p-6 shadow-sm">
                            <h3 className="text-sm font-medium text-gray-500">
                                Today's Sessions
                            </h3>

                            <p className="mt-2 text-3xl font-bold text-orange-600">
                                {stats.today_sessions}
                            </p>
                        </div>

                    </div>

                    {/* Main Content */}
                    <div className="mt-8 grid gap-8 lg:grid-cols-3">

                        {/* Recent Members */}
                        <div className="lg:col-span-2 rounded-xl bg-white shadow-sm">
                            <div className="border-b px-6 py-4">
                                <h2 className="text-lg font-semibold">
                                    Recent Members
                                </h2>
                            </div>

                            <div className="overflow-x-auto">
                                <table className="min-w-full">
                                    <thead>
                                        <tr className="bg-gray-50">
                                            <th className="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                                Name
                                            </th>

                                            <th className="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                                Goal
                                            </th>

                                            <th className="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                                Status
                                            </th>

                                            <th className="px-6 py-3 text-left text-sm font-medium text-gray-500">
                                                Joined
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        {recentClients.map((client) => (
                                            <tr
                                                key={client.id}
                                                className="border-t"
                                            >
                                                <td className="px-6 py-4">
                                                    {client.name}
                                                </td>

                                                <td className="px-6 py-4">
                                                    {client.goal}
                                                </td>

                                                <td className="px-6 py-4">
                                                    <span className="rounded-full bg-green-100 px-3 py-1 text-xs text-green-700">
                                                        {client.status}
                                                    </span>
                                                </td>

                                                <td className="px-6 py-4">
                                                    {client.joined_at}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {/* Upcoming Sessions */}
                        <div className="rounded-xl bg-white shadow-sm">
                            <div className="border-b px-6 py-4">
                                <h2 className="text-lg font-semibold">
                                    Upcoming Sessions
                                </h2>
                            </div>

                            <div className="p-6 space-y-4">
                                {upcomingSessions.length > 0 ? (
                                    upcomingSessions.map((session) => (
                                        <div
                                            key={session.id}
                                            className="rounded-lg border p-4"
                                        >
                                            <h3 className="font-medium">
                                                {session.member_name}
                                            </h3>

                                            <p className="text-sm text-gray-500">
                                                {session.date}
                                            </p>

                                            <p className="mt-1 text-sm text-gray-600">
                                                {session.time}
                                            </p>
                                        </div>
                                    ))
                                ) : (
                                    <p className="text-gray-500">
                                        No upcoming sessions.
                                    </p>
                                )}
                            </div>
                        </div>

                    </div>

                    {/* Quick Actions */}
                    <div className="mt-8 rounded-xl bg-white p-6 shadow-sm">
                        <h2 className="mb-4 text-lg font-semibold">
                            Quick Actions
                        </h2>

                        <div className="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                            <Link
                                href={route("trainer.members.index")}
                                className="rounded-lg border p-4 hover:bg-gray-50"
                            >
                                My Members
                            </Link>

                            <Link
                                href={route("trainer.sessions.index")}
                                className="rounded-lg border p-4 hover:bg-gray-50"
                            >
                                Training Sessions
                            </Link>

                            <Link
                                href={route("trainer.payments.index")}
                                className="rounded-lg border p-4 hover:bg-gray-50"
                            >
                                Earnings
                            </Link>

                            <Link
                                href={route("trainer.profile")}
                                className="rounded-lg border p-4 hover:bg-gray-50"
                            >
                                My Profile
                            </Link>

                        </div>
                    </div>

                </div>
            </div>
            
            </DashboardLayout>
            <Footer/>
        </>
    );
}