import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Members({ members }) {
    return (
        <DashboardLayout>
            <div className="p-6">
                <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900">Member Report</h1>
                        <p className="text-slate-500 mt-1">View members created for this gym.</p>
                    </div>
                </div>

                <div className="overflow-x-auto bg-white rounded-2xl shadow border border-slate-200">
                    <table className="min-w-full divide-y divide-slate-200">
                        <thead className="bg-slate-50">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Name</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Email</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Phone</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Joined</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 bg-white">
                            {members?.map((member) => (
                                <tr key={member.id}>
                                    <td className="px-6 py-4 text-sm text-slate-900">{member.first_name} {member.last_name}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{member.email}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{member.phone ?? "N/A"}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{member.status}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{member.created_at?.split('T')[0]}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </DashboardLayout>
    );
}
