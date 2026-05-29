import DashboardLayout from "@/Layouts/DashboardLayout";
import React from "react";
export default function Index({ members, attendanceToday, activeSubscriptions }) {

    return (
        <DashboardLayout>
        <div className="p-6 grid grid-cols-3 gap-4">

            <div className="bg-white p-4 rounded shadow">
                <h2>Members</h2>
                <p className="text-2xl">{members}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Today Attendance</h2>
                <p className="text-2xl">{attendanceToday}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Active Subscriptions</h2>
                <p className="text-2xl">{activeSubscriptions}</p>
            </div>

        </div>
        </DashboardLayout>
    );
}