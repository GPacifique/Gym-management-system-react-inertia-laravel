import { Link, usePage } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Reception() {
    const { props } = usePage();
    const user = props.auth?.user;

    return (
        <DashboardLayout>
            <div className="space-y-6">

                {/* HEADER */}
                <div className="bg-white rounded-xl p-6 shadow-sm border border-slate-100">
                    <h1 className="text-2xl font-bold text-slate-800">
                        Reception Dashboard
                    </h1>

                    <p className="text-slate-500 mt-1">
                        Welcome back, {user?.name}. Manage members, payments, and check-ins.
                    </p>
                </div>

                {/* QUICK ACTIONS */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <Link
                        href={route("members.create")}
                        className="bg-blue-600 text-white rounded-xl p-5 hover:bg-blue-700 transition shadow"
                    >
                        <div className="text-lg font-semibold">➕ New Member</div>
                        <div className="text-sm opacity-80">
                            Register a new gym member
                        </div>
                    </Link>

                    <Link
                        href={route("member-subscriptions.create")}
                        className="bg-emerald-600 text-white rounded-xl p-5 hover:bg-emerald-700 transition shadow"
                    >
                        <div className="text-lg font-semibold">📦 Subscription</div>
                        <div className="text-sm opacity-80">
                            Assign membership plan
                        </div>
                    </Link>

                    <Link
                        href={route("member-payments.create")}
                        className="bg-indigo-600 text-white rounded-xl p-5 hover:bg-indigo-700 transition shadow"
                    >
                        <div className="text-lg font-semibold">💳 Record Payment</div>
                        <div className="text-sm opacity-80">
                            Register member payment
                        </div>
                    </Link>
                </div>

                {/* MANAGEMENT MODULES */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {/* MEMBERS */}
                    <div className="bg-white rounded-xl p-5 border border-slate-100 shadow-sm">
                        <h2 className="font-semibold text-slate-800 mb-4">
                            👥 Members
                        </h2>

                        <div className="space-y-3">
                            <Link
                                href={route("members.index")}
                                className="block px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100"
                            >
                                View All Members
                            </Link>

                            <Link
                                href={route("attendance.index")}
                                className="block px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100"
                            >
                                Attendance Check-in
                            </Link>

                            <Link
                                href={route("bookings.index")}
                                className="block px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100"
                            >
                                Bookings Management
                            </Link>
                        </div>
                    </div>

                    {/* FINANCE */}
                    <div className="bg-white rounded-xl p-5 border border-slate-100 shadow-sm">
                        <h2 className="font-semibold text-slate-800 mb-4">
                            💰 Finance
                        </h2>

                        <div className="space-y-3">
                            <Link
                                href={route("member-payments.index")}
                                className="block px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100"
                            >
                                Payments
                            </Link>

                            <Link
                                href={route("member-receipts.index")}
                                className="block px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100"
                            >
                                Receipts
                            </Link>

                            <Link
                                href={route("member-subscriptions.index")}
                                className="block px-4 py-2 rounded-lg bg-slate-50 hover:bg-slate-100"
                            >
                                Subscriptions
                            </Link>
                        </div>
                    </div>
                </div>

                {/* SUMMARY CARDS (UI PLACEHOLDER) */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div className="bg-white p-4 rounded-xl border shadow-sm">
                        <p className="text-slate-500 text-sm">Today Check-ins</p>
                        <p className="text-2xl font-bold">--</p>
                    </div>

                    <div className="bg-white p-4 rounded-xl border shadow-sm">
                        <p className="text-slate-500 text-sm">Active Members</p>
                        <p className="text-2xl font-bold">--</p>
                    </div>

                    <div className="bg-white p-4 rounded-xl border shadow-sm">
                        <p className="text-slate-500 text-sm">Pending Payments</p>
                        <p className="text-2xl font-bold">--</p>
                    </div>

                    <div className="bg-white p-4 rounded-xl border shadow-sm">
                        <p className="text-slate-500 text-sm">Expiring Soon</p>
                        <p className="text-2xl font-bold">--</p>
                    </div>

                </div>

            </div>
        </DashboardLayout>
    );
}