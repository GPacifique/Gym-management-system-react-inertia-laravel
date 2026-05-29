import React from "react";
import {
    LineChart,
    Line,
    XAxis,
    YAxis,
    CartesianGrid,
    Tooltip,
    ResponsiveContainer,
    AreaChart,
    Area,
} from "recharts";

export default function MemberAnalyticsCharts() {

    /*
    |--------------------------------------------------------------------------
    | SAMPLE DATA
    |--------------------------------------------------------------------------
    | Replace later with backend API data
    */

    const growthData = [
        { month: "Jan", members: 120 },
        { month: "Feb", members: 150 },
        { month: "Mar", members: 180 },
        { month: "Apr", members: 240 },
        { month: "May", members: 310 },
        { month: "Jun", members: 400 },
    ];

    const retentionData = [
        { month: "Jan", retention: 92 },
        { month: "Feb", retention: 90 },
        { month: "Mar", retention: 88 },
        { month: "Apr", retention: 91 },
        { month: "May", retention: 94 },
        { month: "Jun", retention: 96 },
    ];

    return (
        <div className="grid grid-cols-1 xl:grid-cols-2 gap-6">

            {/* =======================================================
                MEMBER GROWTH CHART
            ======================================================= */}
            <div className="bg-white rounded-2xl shadow p-6">

                <div className="mb-6">
                    <h2 className="text-xl font-bold">
                        Member Growth
                    </h2>

                    <p className="text-gray-500 text-sm">
                        Monthly increase in registered members
                    </p>
                </div>

                <div className="h-80">

                    <ResponsiveContainer width="100%" height="100%">

                        <AreaChart data={growthData}>

                            <defs>
                                <linearGradient id="growthColor" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="5%" stopColor="#2563eb" stopOpacity={0.4} />
                                    <stop offset="95%" stopColor="#2563eb" stopOpacity={0} />
                                </linearGradient>
                            </defs>

                            <CartesianGrid strokeDasharray="3 3" />

                            <XAxis dataKey="month" />

                            <YAxis />

                            <Tooltip />

                            <Area
                                type="monotone"
                                dataKey="members"
                                stroke="#2563eb"
                                fillOpacity={1}
                                fill="url(#growthColor)"
                                strokeWidth={3}
                            />

                        </AreaChart>

                    </ResponsiveContainer>

                </div>

            </div>

            {/* =======================================================
                MEMBER RETENTION CHART
            ======================================================= */}
            <div className="bg-white rounded-2xl shadow p-6">

                <div className="mb-6">
                    <h2 className="text-xl font-bold">
                        Member Retention
                    </h2>

                    <p className="text-gray-500 text-sm">
                        Percentage of members retained monthly
                    </p>
                </div>

                <div className="h-80">

                    <ResponsiveContainer width="100%" height="100%">

                        <LineChart data={retentionData}>

                            <CartesianGrid strokeDasharray="3 3" />

                            <XAxis dataKey="month" />

                            <YAxis domain={[0, 100]} />

                            <Tooltip />

                            <Line
                                type="monotone"
                                dataKey="retention"
                                stroke="#16a34a"
                                strokeWidth={3}
                                dot={{ r: 5 }}
                            />

                        </LineChart>

                    </ResponsiveContainer>

                </div>

            </div>

        </div>
    );
}