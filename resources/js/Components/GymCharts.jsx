import React from "react";
import {
    ResponsiveContainer,
    AreaChart,
    Area,
    BarChart,
    Bar,
    PieChart,
    Pie,
    Cell,
    CartesianGrid,
    XAxis,
    YAxis,
    Tooltip,
    Legend,
} from "recharts";

const COLORS = ["#2563EB", "#10B981", "#F59E0B", "#EF4444"];

export default function DashboardCharts({
    revenueData = [],
    attendanceData = [],
    membershipData = [],
}) {
    return (
        <div className="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-10">

            {/* ================= REVENUE ================= */}
            <div className="bg-white rounded-2xl shadow p-6">

                <h2 className="text-2xl font-bold text-gray-800">
                    Monthly Revenue
                </h2>

                <p className="text-gray-500 mt-1 mb-4">
                    Revenue growth overview
                </p>

                <div className="h-80">
                    <ResponsiveContainer width="100%" height="100%">
                        <AreaChart data={revenueData}>
                            <defs>
                                <linearGradient id="revenue" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="5%" stopColor="#2563EB" stopOpacity={0.8} />
                                    <stop offset="95%" stopColor="#2563EB" stopOpacity={0} />
                                </linearGradient>
                            </defs>

                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="month" />
                            <YAxis />
                            <Tooltip />

                            <Area
                                type="monotone"
                                dataKey="revenue"
                                stroke="#2563EB"
                                fill="url(#revenue)"
                            />
                        </AreaChart>
                    </ResponsiveContainer>
                </div>
            </div>

            {/* ================= ATTENDANCE ================= */}
            <div className="bg-white rounded-2xl shadow p-6">

                <h2 className="text-2xl font-bold text-gray-800">
                    Weekly Attendance
                </h2>

                <p className="text-gray-500 mt-1 mb-4">
                    Member check-ins per day
                </p>

                <div className="h-80">
                    <ResponsiveContainer width="100%" height="100%">
                        <BarChart data={attendanceData}>
                            <CartesianGrid strokeDasharray="3 3" />
                            <XAxis dataKey="day" />
                            <YAxis />
                            <Tooltip />
                            <Legend />

                            <Bar
                                dataKey="members"
                                fill="#10B981"
                                radius={[10, 10, 0, 0]}
                            />
                        </BarChart>
                    </ResponsiveContainer>
                </div>
            </div>

            {/* ================= MEMBERSHIP ================= */}
            <div className="bg-white rounded-2xl shadow p-6 xl:col-span-2">

                <h2 className="text-2xl font-bold text-gray-800">
                    Membership Distribution
                </h2>

                <p className="text-gray-500 mt-1 mb-4">
                    Active subscription breakdown
                </p>

                <div className="h-96 flex items-center justify-center">
                    <ResponsiveContainer width="100%" height="100%">
                        <PieChart>
                            <Pie
                                data={membershipData}
                                dataKey="value"
                                cx="50%"
                                cy="50%"
                                outerRadius={140}
                                label
                            >
                                {membershipData.map((entry, index) => (
                                    <Cell
                                        key={index}
                                        fill={COLORS[index % COLORS.length]}
                                    />
                                ))}
                            </Pie>

                            <Tooltip />
                            <Legend />
                        </PieChart>
                    </ResponsiveContainer>
                </div>
            </div>

        </div>
    );
}