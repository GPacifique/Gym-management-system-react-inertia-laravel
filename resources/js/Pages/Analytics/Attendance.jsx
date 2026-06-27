import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Attendance({ attendances }) {
    return (
        <DashboardLayout>
            <div className="p-6">
                <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900">Attendance Report</h1>
                        <p className="text-slate-500 mt-1">Review check-in history for this gym.</p>
                    </div>
                </div>

                <div className="overflow-x-auto bg-white rounded-2xl shadow border border-slate-200">
                    <table className="min-w-full divide-y divide-slate-200">
                        <thead className="bg-slate-50">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Member</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Check In</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Check Out</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Branch</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 bg-white">
                            {attendances?.map((attendance) => (
                                <tr key={attendance.id}>
                                    <td className="px-6 py-4 text-sm text-slate-900">{attendance.member?.first_name} {attendance.member?.last_name}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{attendance.check_in}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{attendance.check_out ?? '---'}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{attendance.branch_id ?? 'N/A'}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </DashboardLayout>
    );
}
