import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Payments({ payments }) {
    return (
        <DashboardLayout>
            <div className="p-6">
                <div className="mb-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-slate-900">Payments Report</h1>
                        <p className="text-slate-500 mt-1">Review payment activity for this gym.</p>
                    </div>
                </div>

                <div className="overflow-x-auto bg-white rounded-2xl shadow border border-slate-200">
                    <table className="min-w-full divide-y divide-slate-200">
                        <thead className="bg-slate-50">
                            <tr>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Member</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Amount</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Method</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Status</th>
                                <th className="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Date</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-slate-100 bg-white">
                            {payments?.map((payment) => (
                                <tr key={payment.id}>
                                    <td className="px-6 py-4 text-sm text-slate-900">{payment.member?.first_name} {payment.member?.last_name}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{payment.amount}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{payment.payment_method}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{payment.status}</td>
                                    <td className="px-6 py-4 text-sm text-slate-500">{payment.payment_date}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </DashboardLayout>
    );
}
