import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import React from "react";

export default function Index({ members, revenue, subscriptions, attendanceToday }) {

    return (
        <AuthenticatedLayout>
        <div className="p-6 grid grid-cols-4 gap-4">

            <div className="bg-white p-4 rounded shadow">
                <h2>Members</h2>
                <p className="text-2xl font-bold">{members}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Revenue</h2>
                <p className="text-2xl font-bold">${revenue}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Subscriptions</h2>
                <p className="text-2xl font-bold">{subscriptions}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Today's Attendance</h2>
                <p className="text-2xl font-bold">{attendanceToday}</p>
            </div>

        </div>
        </AuthenticatedLayout>
    );
}