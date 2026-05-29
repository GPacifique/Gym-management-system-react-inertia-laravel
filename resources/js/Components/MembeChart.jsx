import React from "react";
import {
    LineChart,
    Line,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    ResponsiveContainer,
    PieChart,
    Pie,
    Cell,
} from "recharts";

const progressData = [
    { month: "Jan", weight: 90 },
    { month: "Feb", weight: 87 },
    { month: "Mar", weight: 84 },
    { month: "Apr", weight: 82 },
    { month: "May", weight: 80 },
];

const attendanceData = [
    { name: "Present", value: 22 },
    { name: "Absent", value: 8 },
];

const COLORS = ["#22c55e", "#ef4444"];

export default function MemberCharts() {
    return (
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div className="bg-white rounded-2xl shadow p-5">
                <h2 className="text-lg font-bold mb-4">Weight Progress</h2>

                <ResponsiveContainer width="100%" height={300}>
                    <LineChart data={progressData}>
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="month" />
                        <YAxis />
                        <Tooltip />
                        <Line
                            type="monotone"
                            dataKey="weight"
                            stroke="#3b82f6"
                            strokeWidth={3}
                        />
                    </LineChart>
                </ResponsiveContainer>
            </div>

            <div className="bg-white rounded-2xl shadow p-5">
                <h2 className="text-lg font-bold mb-4">Attendance</h2>

                <ResponsiveContainer width="100%" height={300}>
                    <PieChart>
                        <Pie
                            data={attendanceData}
                            cx="50%"
                            cy="50%"
                            outerRadius={100}
                            dataKey="value"
                            label
                        >
                            {attendanceData.map((entry, index) => (
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
        </div>
    );
}