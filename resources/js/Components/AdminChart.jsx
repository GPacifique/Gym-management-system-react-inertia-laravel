import React from "react";
import {
    ComposedChart,
    Line,
    Bar,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    Legend,
    ResponsiveContainer,
} from "recharts";

const systemData = [
    {
        month: "Jan",
        users: 400,
        revenue: 2400,
    },
    {
        month: "Feb",
        users: 500,
        revenue: 3200,
    },
    {
        month: "Mar",
        users: 700,
        revenue: 5000,
    },
    {
        month: "Apr",
        users: 1000,
        revenue: 7200,
    },
    {
        month: "May",
        users: 1400,
        revenue: 9600,
    },
];

export default function AdminCharts() {
    return (
        <div className="bg-white rounded-2xl shadow p-5">
            <h2 className="text-lg font-bold mb-4">System Analytics</h2>

            <ResponsiveContainer width="100%" height={400}>
                <ComposedChart data={systemData}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="month" />
                    <YAxis />
                    <Tooltip />
                    <Legend />

                    <Bar
                        dataKey="revenue"
                        fill="#3b82f6"
                        radius={[10,10,0,0]}
                    />

                    <Line
                        type="monotone"
                        dataKey="users"
                        stroke="#ef4444"
                        strokeWidth={3}
                    />
                </ComposedChart>
            </ResponsiveContainer>
        </div>
    );
}
