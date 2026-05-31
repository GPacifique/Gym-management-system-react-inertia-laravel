import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage, Link } from "@inertiajs/react";
import AssignedMembers from "@/Components/AssignedMembers";

export default function Dashboard() {
    const { auth } = usePage().props;

    const user = auth.user;

    return (
        <DashboardLayout user={user}>
            <Head title="Trainer Dashboard" />

            {/* PAGE HEADER */}
            <div className="flex items-center justify-between mb-6">
                <div>
                    <h1 className="text-7xl font-bold text-gray-100">
                        Trainer Dashboard
                    </h1>

                    <p className="text-4xl font-bold text-gray-500 mt-1">
                        Welcome back, {user.name}
                    </p>
                </div>

                <div>
                    <span className="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-medium">
                        Active Trainer
                    </span>
                </div>
            </div>

            {/* STATS */}
            <div className="grid grid-cols-1 md:grid-cols-4 gap-5">

                <StatCard
                    title="Assigned Members"
                    value="0"
                />

                <StatCard
                    title="Sessions Today"
                    value="0"
                />

                <StatCard
                    title="Workout Programs"
                    value="0"
                />

                <StatCard
                    title="Pending Reviews"
                    value="0"
                />

            </div>

            {/* QUICK ACTIONS */}
            <div className="mt-10 bg-white rounded-2xl shadow p-6">

                <h2 className="text-xl font-bold text-gray-800 mb-5">
                    Quick Actions
                </h2>

                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <Link
                        href="#"
                        className="bg-blue-600 hover:bg-blue-700 transition text-white p-4 rounded-xl"
                    >
                        <h3 className="font-semibold">
                            Create Workout Plan
                        </h3>

                        <p className="text-sm mt-2 opacity-90">
                            Build customized training programs
                        </p>
                    </Link>

                    <Link
                        href="#"
                        className="bg-purple-600 hover:bg-purple-700 transition text-white p-4 rounded-xl"
                    >
                        <h3 className="font-semibold">
                            View Assigned Members
                        </h3>

                        <p className="text-sm mt-2 opacity-90">
                            Monitor member progress
                        </p>
                    </Link>

                    <Link
                        href="#"
                        className="bg-green-600 hover:bg-green-700 transition text-white p-4 rounded-xl"
                    >
                        <h3 className="font-semibold">
                            Nutrition Plans
                        </h3>

                        <p className="text-sm mt-2 opacity-90">
                            Create meal recommendations
                        </p>
                    </Link>

                    <Link
                        href="#"
                        className="bg-orange-600 hover:bg-orange-700 transition text-white p-4 rounded-xl"
                    >
                        <h3 className="font-semibold">
                            Attendance Reports
                        </h3>

                        <p className="text-sm mt-2 opacity-90">
                            Review member attendance
                        </p>
                    </Link>

                </div>
            </div>

            {/* TODAY SCHEDULE */}
            <div className="mt-10 bg-white rounded-2xl shadow p-6">

                <h2 className="text-xl font-bold text-gray-800 mb-5">
                    Today's Schedule
                </h2>

                <div className="overflow-x-auto">

                    <table className="w-full border-collapse">

                        <thead>
                            <tr className="bg-gray-100 text-left">
                                <th className="p-3">Time</th>
                                <th className="p-3">Client</th>
                                <th className="p-3">Session Type</th>
                                <th className="p-3">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr className="border-b">
                                <td className="p-3">08:00 AM</td>
                                <td className="p-3">No Sessions</td>
                                <td className="p-3">-</td>
                                <td className="p-3">
                                    <span className="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">
                                        Pending
                                    </span>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>
                <AssignedMembers/>
            </div>

        </DashboardLayout>
    );
}

/*
|--------------------------------------------------------------------------
| REUSABLE CARD COMPONENT
|--------------------------------------------------------------------------
*/

function StatCard({ title, value }) {
    return (
        <div className="bg-white rounded-2xl shadow p-5">
            <p className="text-gray-500 text-sm">
                {title}
            </p>

            <h2 className="text-3xl font-bold mt-2 text-gray-800">
                {value}
            </h2>
        </div>
    );
}