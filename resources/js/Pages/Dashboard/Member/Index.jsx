import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";
export default function Index({ myAttendance, mySubscription }) {

    return (<DashboardLayout>
        <div className="p-6 grid grid-cols-2 gap-4">

            <div className="bg-white p-4 rounded shadow">
                <h2>My Attendance</h2>
                <p className="text-2xl">{myAttendance}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Active Subscription</h2>

                <p className="text-sm">
                    {mySubscription ? mySubscription.name : "No Active Plan"}
                </p>

            </div>

        </div>
        </DashboardLayout>
    );
}