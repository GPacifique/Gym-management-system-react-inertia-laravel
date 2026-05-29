import React from "react";
import {
    PieChart,
    Pie,
    Cell,
    Tooltip,
    ResponsiveContainer,
} from "recharts";

const branchData = [
    { name: "Kigali Branch", value: 400 },
    { name: "Musanze Branch", value: 300 },
    { name: "Huye Branch", value: 200 },
    { name: "Rubavu Branch", value: 100 },
];

const COLORS = ["#3b82f6", "#10b981", "#f59e0b", "#ef4444"];

export default function OwnerCharts() {
    return (
        <div className="bg-white rounded-2xl shadow p-5">
            <h2 className="text-lg font-bold mb-4">Members Per Branch</h2>

            <ResponsiveContainer width="100%" height={350}>
                <PieChart>
                    <Pie
                        data={branchData}
                        cx="50%"
                        cy="50%"
                        outerRadius={120}
                        dataKey="value"
                        label
                    >
                        {branchData.map((entry, index) => (
                            <Cell
                                key={index}
                                fill={COLORS[index % COLORS.length]}
                            />
                        ))}
                    </Pie>
                    <Tooltip />
                </PieChart>
            </ResponsiveContainer>
        </div>
    );
}