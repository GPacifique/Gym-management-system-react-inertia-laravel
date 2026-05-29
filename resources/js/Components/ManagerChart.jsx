import React from "react";
import {
    AreaChart,
    Area,
    XAxis,
    YAxis,
    Tooltip,
    CartesianGrid,
    ResponsiveContainer,
} from "recharts";

const revenueData = [
    { month: "Jan", revenue: 4000 },
    { month: "Feb", revenue: 6000 },
    { month: "Mar", revenue: 9000 },
    { month: "Apr", revenue: 12000 },
    { month: "May", revenue: 16000 },
];

export default function ManagerCharts() {
    return (
        <div className="bg-white rounded-2xl shadow p-5">
            <h2 className="text-lg font-bold mb-4">Monthly Revenue</h2>

            <ResponsiveContainer width="100%" height={350}>
                <AreaChart data={revenueData}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="month" />
                    <YAxis />
                    <Tooltip />
                    <Area
                        type="monotone"
                        dataKey="revenue"
                        stroke="#10b981"
                        fill="#6ee7b7"
                    />
                </AreaChart>
            </ResponsiveContainer>
        </div>
    );
}