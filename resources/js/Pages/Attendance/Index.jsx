import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { usePage, Link } from "@inertiajs/react";

export default function Index() {
    const { attendances } = usePage().props;

    return (
        <DashboardLayout>
            <div className="p-6 space-y-6">

                {/* HEADER */}
                <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h1 className="text-3xl font-bold text-gray-800">
                            Attendance Records
                        </h1>

                        <p className="text-gray-500 mt-1">
                            Track member check-ins per gym
                        </p>
                    </div>

                </div>

                {/* TABLE CARD */}
                <div className="bg-white rounded-2xl shadow overflow-hidden">

                    <table className="w-full text-sm">

                        <thead className="bg-gray-100 text-gray-700">
                            <tr>
                                <th className="text-left p-4">Member</th>
                                <th className="text-left p-4">Check-in Time</th>
                                <th className="text-left p-4">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            {attendances?.data && attendances.data.length > 0 ? (
                                attendances.data.map((att) => (
                                    <tr
                                        key={att.id}
                                        className="border-t hover:bg-gray-50 transition"
                                    >

                                        {/* MEMBER NAME */}
                                        <td className="p-4 font-semibold text-gray-800">
                                            {att.member_name ?? "Unknown Member"}
                                        </td>

                                        {/* TIME */}
                                        <td className="p-4 text-gray-600">
                                            {att.check_in_time
                                                ? new Date(att.check_in_time).toLocaleString()
                                                : "N/A"}
                                        </td>

                                        {/* STATUS */}
                                        <td className="p-4">
                                            <span className={`px-3 py-1 rounded-full text-xs font-medium
                                                ${
                                                    att.status === "present"
                                                        ? "bg-green-100 text-green-700"
                                                        : "bg-red-100 text-red-700"
                                                }
                                            `}>
                                                {att.status ?? "unknown"}
                                            </span>
                                        </td>

                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan="3" className="p-10 text-center text-gray-500">
                                        No attendance records found for this gym.
                                    </td>
                                </tr>
                            )}

                        </tbody>

                    </table>

                </div>

                {/* PAGINATION */}
                {attendances?.links && attendances.links.length > 0 && (
                    <div className="flex gap-2 flex-wrap">
                        {attendances.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url ?? "#"}
                                className={`px-3 py-1 rounded text-sm border transition
                                    ${
                                        link.active
                                            ? "bg-blue-600 text-white border-blue-600"
                                            : "bg-white hover:bg-gray-100"
                                    }
                                `}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ))}
                    </div>
                )}

            </div>
        </DashboardLayout>
    );
}