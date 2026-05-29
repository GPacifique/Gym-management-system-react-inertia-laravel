import React from "react";
import {
    BarChart,
    Bar,
    XAxis,
    YAxis,
    Tooltip,
    CartesianGrid,
    ResponsiveContainer,
} from "recharts";

const clientsData = [
    { month: "Jan", clients: 10 },
    { month: "Feb", clients: 15 },
    { month: "Mar", clients: 18 },
    { month: "Apr", clients: 25 },
    { month: "May", clients: 30 },
];

export default function TrainerCharts() {
    return (
        <div className="bg-white rounded-2xl shadow p-5">
            <h2 className="text-lg font-bold mb-4">Clients Growth</h2>

            <ResponsiveContainer width="100%" height={350}>
                <BarChart data={clientsData}>
                    <CartesianGrid strokeDasharray="3 3" />
                    <XAxis dataKey="month" />
                    <YAxis />
                    <Tooltip />
                    <Bar dataKey="clients" fill="#8b5cf6" radius={[10,10,0,0]} />
                </BarChart>
            </ResponsiveContainer>
        </div>
    );
}