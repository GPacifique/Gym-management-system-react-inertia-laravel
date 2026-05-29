import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Index({ members, todayCheckIns }) {

    return (<DashboardLayout>
        <div className="p-6 grid grid-cols-2 gap-4">

            <div className="bg-white p-4 rounded shadow">
                <h2>Total Members</h2>
                <p className="text-2xl">{members}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Today's Check-ins</h2>
                <p className="text-2xl">{todayCheckIns}</p>
            </div>

        </div>
        </DashboardLayout>
    );
}