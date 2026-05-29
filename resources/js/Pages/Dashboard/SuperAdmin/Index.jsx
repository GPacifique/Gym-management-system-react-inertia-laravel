import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Index({ totalBusinesses, totalMembers, totalRevenue, totalSubscriptions }) {

    return (<DashboardLayout>
        <div className="p-6 grid grid-cols-4 gap-4">

            <div className="bg-white p-4 rounded shadow">
                <h2>Total Businesses</h2>
                <p className="text-2xl font-bold">{totalBusinesses}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Total Members</h2>
                <p className="text-2xl font-bold">{totalMembers}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Total Revenue</h2>
                <p className="text-2xl font-bold">${totalRevenue}</p>
            </div>

            <div className="bg-white p-4 rounded shadow">
                <h2>Subscriptions</h2>
                <p className="text-2xl font-bold">{totalSubscriptions}</p>
            </div>

        </div>
        </DashboardLayout>
    );
}