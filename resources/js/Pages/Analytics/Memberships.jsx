import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Memberships({ memberships }) {
    return (
        <DashboardLayout>
            <div className="p-6">
                <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900">Membership Report</h1>
                        <p className="text-slate-500 mt-1">Review membership records for this gym.</p>
                    </div>
                </div>

                <div className="overflow-x-auto bg-white rounded-2xl shadow border border-slate-200">
                    <table className="min-w-full divide-y divide-slate-200">
                        <thead className="bg-slate-50">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Member</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Plan</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Start</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">End</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 bg-white">
                            {memberships?.map((membership) => (
                                <tr key={membership.id}>
                                    <td className="px-6 py-4 text-sm text-slate-900">{membership.member?.first_name} {membership.member?.last_name}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{membership.membership_plan?.name ?? membership.membershipPlan?.name ?? "Unknown"}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{membership.status}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{membership.start_date}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{membership.end_date}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </DashboardLayout>
    );
}
