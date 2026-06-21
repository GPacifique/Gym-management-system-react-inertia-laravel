import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Index({ assignedMembers, todaySessions }) {

    return (
        <DashboardLayout>
        <div className="p-6 grid grid-cols-2 gap-4">

            <div className="bg-white p-4 rounded shadow">
                <h2>Assigned Members</h2>
                <p className="text-2xl">{assignedMembers}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Today's Sessions</h2>
                <p className="text-2xl">{todaySessions}</p>
            </div>

        </div>
        </DashboardLayout>
    );
}