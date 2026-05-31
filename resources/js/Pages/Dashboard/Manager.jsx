import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { usePage } from "@inertiajs/react";
import GymCharts from "@/Components/GymCharts";

export default function Manager() {

    const { auth, stats, charts } = usePage().props;

    const user = auth.user;

    return (
        <DashboardLayout user={user}>

            <div className="p-6 space-y-8">

                {/* HEADER */}
                <div>
                    <h1 className="text-7xl font-bold text-gray-100">
                        Manager Dashboard
                    </h1>

                    <p className="text-4xl mt-3 text-gray-400">
                        Track attendance, bookings, and gym operations.
                    </p>
                </div>

                {/* STATS */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {/* ATTENDANCE */}
                    <div className="bg-blue-500 text-white rounded-2xl p-6 shadow">

                        <h2 className="text-lg">
                            Today's Attendance
                        </h2>

                        <p className="text-4xl font-bold mt-3">
                            {stats?.today_attendance ?? 0}
                        </p>

                    </div>

                    {/* BOOKINGS */}
                    <div className="bg-green-500 text-white rounded-2xl p-6 shadow">

                        <h2 className="text-lg">
                            Bookings
                        </h2>

                        <p className="text-4xl font-bold mt-3">
                            {stats?.today_bookings ?? 0}
                        </p>

                    </div>

                </div>

                {/* CHARTS */}
                <div className="space-y-6">

                    <GymCharts data={charts} />

                </div>

            </div>

        </DashboardLayout>
    );
}