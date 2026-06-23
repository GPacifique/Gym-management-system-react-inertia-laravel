import React from "react";
import DashboardLayout from "@/Layouts/DashboardLayout";
import { router } from "@inertiajs/react";

export default function Show({ member, membership, payments = [], attendance = [] }) {
    const activeMembership = membership;

    return (
        <DashboardLayout>
            <div className="max-w-5xl mx-auto space-y-6">

                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-2xl font-bold">
                            {member.first_name} {member.last_name}
                        </h1>
                        <p className="text-gray-500">
                            Member No: {member.member_number}
                        </p>
                    </div>

                    <div className="space-x-2">
                        <button
                            onClick={() =>
                                router.visit(route("members.edit", member.id))
                            }
                            className="px-4 py-2 bg-blue-600 text-white rounded"
                        >
                            Edit
                        </button>

                        <button
                            onClick={() => {
                                if (confirm("Are you sure you want to delete this member?")) {
                                    router.delete(route("members.destroy", member.id));
                                }
                            }}
                            className="px-4 py-2 bg-red-600 text-white rounded"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                {/* Member Info */}
                <div className="bg-white shadow rounded-lg p-6 grid grid-cols-2 gap-6">

                    <div>
                        <p className="text-sm text-gray-500">Phone</p>
                        <p className="font-medium">{member.phone ?? "N/A"}</p>
                    </div>

                    <div>
                        <p className="text-sm text-gray-500">Email</p>
                        <p className="font-medium">{member.email ?? "N/A"}</p>
                    </div>

                    <div>
                        <p className="text-sm text-gray-500">Status</p>
                        <span className={`px-3 py-1 rounded text-white text-sm
                            ${member.status === "active" ? "bg-green-600" :
                              member.status === "inactive" ? "bg-gray-500" :
                              member.status === "suspended" ? "bg-yellow-600" :
                              "bg-red-600"}
                        `}>
                            {member.status}
                        </span>
                    </div>

                    <div>
                        <p className="text-sm text-gray-500">Created At</p>
                        <p className="font-medium">
                            {new Date(member.created_at).toLocaleDateString()}
                        </p>
                    </div>
                </div>

                {/* ===================== */}
                {/* MEMBERSHIP (REAL DATA) */}
                {/* ===================== */}
                <div className="bg-white p-4 rounded shadow">
                    <h2 className="font-semibold mb-3">Membership</h2>

                    {activeMembership ? (
                        <div className="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p className="text-gray-500">Plan</p>
                                <p className="font-medium">
                                    {activeMembership.membership_plan?.name}
                                </p>
                            </div>

                            <div>
                                <p className="text-gray-500">Status</p>
                                <p className="font-medium">
                                    {activeMembership.status}
                                </p>
                            </div>

                            <div>
                                <p className="text-gray-500">Start Date</p>
                                <p className="font-medium">
                                    {activeMembership.start_date}
                                </p>
                            </div>

                            <div>
                                <p className="text-gray-500">End Date</p>
                                <p className="font-medium">
                                    {activeMembership.end_date}
                                </p>
                            </div>

                            <div>
                                <p className="text-gray-500">Amount</p>
                                <p className="font-medium">
                                    {activeMembership.amount}
                                </p>
                            </div>
                        </div>
                    ) : (
                        <p className="text-sm text-gray-500">
                            No active membership found.
                        </p>
                    )}
                </div>

                {/* ===================== */}
                {/* PAYMENTS */}
                {/* ===================== */}
                <div className="bg-white p-4 rounded shadow">
                    <h2 className="font-semibold mb-3">Payments</h2>

                    {payments.length > 0 ? (
                        <div className="space-y-2">
                            {payments.map((p) => (
                                <div key={p.id} className="flex justify-between text-sm border-b py-2">
                                    <span>{p.payment_method}</span>
                                    <span className="font-medium">{p.amount}</span>
                                    <span>{p.payment_date}</span>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <p className="text-sm text-gray-500">
                            No payment records found.
                        </p>
                    )}
                </div>

                {/* ===================== */}
                {/* ATTENDANCE */}
                {/* ===================== */}
                <div className="bg-white p-4 rounded shadow">
                    <h2 className="font-semibold mb-3">Attendance</h2>

                    {attendance.length > 0 ? (
                        <div className="space-y-2">
                            {attendance.map((a) => (
                                <div key={a.id} className="flex justify-between text-sm border-b py-2">
                                    <span>Check-in: {a.check_in}</span>
                                    <span>Check-out: {a.check_out ?? "-"}</span>
                                </div>
                            ))}
                        </div>
                    ) : (
                        <p className="text-sm text-gray-500">
                            No attendance records found.
                        </p>
                    )}
                </div>

            </div>
        </DashboardLayout>
    );
}