import DashboardCharts from "@/Components/GymCharts";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard() {
    const { auth } = usePage().props;

    const user = auth.user;

    return (
        <DashboardLayout user={user}>
            <Head title="Gym Owner Dashboard" />

            {/* HEADER */}
            <div className="mb-6">
                <h1 className="text-3xl font-bold text-gray-800">
                    Gym Owner Dashboard
                </h1>

                <p className="text-gray-500">
                    Welcome back, {user.name}
                </p>
            </div>
 <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

                <div className="bg-white rounded-2xl shadow p-6">
                    <h2 className="text-gray-500">Total Members</h2>
                    <p className="text-3xl font-bold mt-2">1,240</p>
                </div>

                <div className="bg-white rounded-2xl shadow p-6">
                    <h2 className="text-gray-500">Monthly Revenue</h2>
                    <p className="text-3xl font-bold mt-2">$12,800</p>
                </div>

                <div className="bg-white rounded-2xl shadow p-6">
                    <h2 className="text-gray-500">Active Trainers</h2>
                    <p className="text-3xl font-bold mt-2">18</p>
                </div>

            </div>
            {/* STATS GRID */}
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4">

                <div className="bg-white p-4 rounded-xl shadow">
                    <h2 className="text-sm text-gray-500">Total Members</h2>
                    <p className="text-2xl font-bold">0</p>
                </div>

                <div className="bg-white p-4 rounded-xl shadow">
                    <h2 className="text-sm text-gray-500">Active Subscriptions</h2>
                    <p className="text-2xl font-bold">0</p>
                </div>

                <div className="bg-white p-4 rounded-xl shadow">
                    <h2 className="text-sm text-gray-500">Today Check-ins</h2>
                    <p className="text-2xl font-bold">0</p>
                </div>

                <div className="bg-white p-4 rounded-xl shadow">
                    <h2 className="text-sm text-gray-500">Monthly Revenue</h2>
                    <p className="text-2xl font-bold">$0</p>
                </div>
            </div>

            {/* QUICK ACTIONS */}
            <div className="mt-8">
                <h2 className="text-xl font-semibold mb-4">
                    Quick Actions
                </h2>

                <div className="flex gap-4 flex-wrap">

                    <button className="bg-blue-600 text-white px-4 py-2 rounded-lg">
                        Add Member
                    </button>

                    <button className="bg-green-600 text-white px-4 py-2 rounded-lg">
                        Create Subscription Plan
                    </button>

                    <button className="bg-purple-600 text-white px-4 py-2 rounded-lg">
                        Manage Trainers
                    </button>

                    <button className="bg-gray-800 text-white px-4 py-2 rounded-lg">
                        View Reports
                    </button>

                </div>
            </div>

            {/* INFO PANEL */}
            <div className="mt-10 bg-white p-6 rounded-xl shadow">
                <h2 className="text-lg font-bold mb-2">
                    Gym Overview
                </h2>

                <p className="text-gray-600">
                    This dashboard will show real-time analytics for your gym including members, revenue, attendance, and facility usage.
                </p>
                <DashboardCharts/>
            </div>
        </DashboardLayout>
    );
}
   