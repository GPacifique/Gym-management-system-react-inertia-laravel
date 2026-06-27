import { useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import AuthenticatedLayout from "./AuthenticatedLayout";

export default function DashboardLayout({ children }) {
    const { props, url } = usePage();
    const user = props.auth?.user;

    const [sidebarOpen, setSidebarOpen] = useState(true);

    const hasRole = (...roles) => roles.includes(user?.role);

    const navClass = (path) => {
        const active = url.startsWith(path);

        return [
            "flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium transition",
            "whitespace-nowrap",
            active
                ? "bg-blue-50 text-blue-700 border-l-4 border-blue-600"
                : "text-slate-600 hover:bg-slate-100"
        ].join(" ");
    };

    return (
        <AuthenticatedLayout>
            <div className="flex h-screen bg-slate-50">

                {/* SIDEBAR */}
                <aside
                    className={`
                        bg-white border-r border-slate-200
                        flex flex-col
                        transition-all duration-300
                        ${sidebarOpen ? "w-72" : "w-20"}
                    `}
                >

                    {/* HEADER */}
                    <div className="flex items-center justify-between px-4 py-4 border-b border-slate-200">
                        {sidebarOpen && (
                            <div>
                                <h1 className="text-lg font-bold text-slate-800">
                                    GymMate
                                </h1>
                                <p className="text-xs text-slate-500">
                                    Gym Management System
                                </p>
                            </div>
                        )}

                        <button
                            onClick={() => setSidebarOpen(!sidebarOpen)}
                            className="p-2 rounded-md hover:bg-slate-100"
                        >
                            ☰
                        </button>
                    </div>

                    {/* NAVIGATION */}
                    <div className="flex-1 overflow-y-auto px-3 py-4 space-y-6">

                        {/* GENERAL */}
                        <div>
                            {sidebarOpen && (
                                <p className="text-xs text-slate-400 uppercase mb-2">
                                    General
                                </p>
                            )}

                            <Link href={route("dashboard")} className={navClass("/dashboard")}>
                                📊 {sidebarOpen && "Dashboard"}
                            </Link>

                            <Link href={route("profile.edit")} className={navClass("/profile")}>
                                👤 {sidebarOpen && "Profile"}
                            </Link>
                        </div>

                        {/* QUICK ACTIONS */}
                        {hasRole("super_admin", "business_owner", "manager", "receptionist") && (
                            <div>
                                {sidebarOpen && (
                                    <p className="text-xs text-slate-400 uppercase mb-2">
                                        Quick Actions
                                    </p>
                                )}

                                <Link href={route("members.create")} className={navClass("/members/create")}>
                                    ➕ {sidebarOpen && "New Member"}
                                </Link>

                                <Link href={route("member-subscriptions.create")} className={navClass("/member-subscriptions/create")}>
                                    📦 {sidebarOpen && "New Subscription"}
                                </Link>

                                <Link href={route("member-payments.create")} className={navClass("/member-payments/create")}>
                                    💳 {sidebarOpen && "Record Payment"}
                                </Link>
                            </div>
                        )}

                        {/* MEMBERS */}
                        {hasRole("super_admin", "business_owner", "manager", "receptionist") && (
                            <div>
                                {sidebarOpen && (
                                    <p className="text-xs text-slate-400 uppercase mb-2">
                                        Members
                                    </p>
                                )}

                                <Link href={route("members.index")} className={navClass("/members")}>
                                    👥 {sidebarOpen && "Members"}
                                </Link>

                                <Link href={route("attendance.index")} className={navClass("/attendance")}>
                                    📅 {sidebarOpen && "Attendance"}
                                </Link>

                                <Link href={route("bookings.index")} className={navClass("/bookings")}>
                                    📖 {sidebarOpen && "Bookings"}
                                </Link>
                            </div>
                        )}

                        {/* MEMBERSHIP */}
                        {hasRole("super_admin", "business_owner", "manager", "receptionist") && (
                            <div>
                                {sidebarOpen && (
                                    <p className="text-xs text-slate-400 uppercase mb-2">
                                        Membership
                                    </p>
                                )}

                                <Link href={route("membership-plans.index")} className={navClass("/membership-plans")}>
                                    📋 {sidebarOpen && "Plans"}
                                </Link>

                                <Link href={route("member-subscriptions.index")} className={navClass("/member-subscriptions")}>
                                    📦 {sidebarOpen && "Subscriptions"}
                                </Link>

                                <Link href={route("member-notifications.index")} className={navClass("/member-notifications")}>
                                    🔔 {sidebarOpen && "Notifications"}
                                </Link>
                            </div>
                        )}

                        {/* FINANCE */}
                        {hasRole("super_admin", "business_owner", "manager", "receptionist") && (
                            <div>
                                {sidebarOpen && (
                                    <p className="text-xs text-slate-400 uppercase mb-2">
                                        Finance
                                    </p>
                                )}

                                <Link href={route("member-payments.index")} className={navClass("/member-payments")}>
                                    💰 {sidebarOpen && "Payments"}
                                </Link>

                                <Link href={route("member-receipts.index")} className={navClass("/member-receipts")}>
                                    🧾 {sidebarOpen && "Receipts"}
                                </Link>
                            </div>
                        )}

                        {/* PROGRAMS */}
                        {hasRole("business_owner", "manager", "trainer") && (
                            <div>
                                {sidebarOpen && (
                                    <p className="text-xs text-slate-400 uppercase mb-2">
                                        Programs
                                    </p>
                                )}

                                <Link href={route("workout-programs.index")} className={navClass("/workout-programs")}>
                                    🏋️ {sidebarOpen && "Workouts"}
                                </Link>

                                <Link href={route("nutrition-plans.index")} className={navClass("/nutrition-plans")}>
                                    🥗 {sidebarOpen && "Nutrition"}
                                </Link>
                            </div>
                        )}

                        {/* REPORTS */}
                        {hasRole("business_owner", "manager") && (
                            <div>
                                {sidebarOpen && (
                                    <p className="text-xs text-slate-400 uppercase mb-2">
                                        Reports
                                    </p>
                                )}

                                <Link href={route("reports.members")} className={navClass("/reports/members")}>
                                    📈 {sidebarOpen && "Member Reports"}
                                </Link>

                                <Link href={route("reports.memberships")} className={navClass("/reports/memberships")}>
                                    🧾 {sidebarOpen && "Membership Reports"}
                                </Link>

                                <Link href={route("reports.payments")} className={navClass("/reports/payments")}>
                                    💵 {sidebarOpen && "Payment Reports"}
                                </Link>

                                <Link href={route("reports.attendance")} className={navClass("/reports/attendance")}>
                                    🗓️ {sidebarOpen && "Attendance Reports"}
                                </Link>
                            </div>
                        )}
                    </div>

                    {/* USER */}
                    <div className="border-t border-slate-200 p-4">
                        {sidebarOpen && (
                            <>
                                <p className="font-semibold text-slate-800">
                                    {user?.name}
                                </p>
                                <p className="text-xs text-slate-500 capitalize">
                                    {user?.role?.replace("_", " ")}
                                </p>
                            </>
                        )}

                        <Link
                            href={route("logout")}
                            method="post"
                            as="button"
                            className="w-full mt-3 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm"
                        >
                            {sidebarOpen ? "Logout" : "🚪"}
                        </Link>
                    </div>

                </aside>

                {/* MAIN CONTENT */}
                <main className="flex-1 overflow-y-auto p-6">
                    {children}
                </main>

            </div>
        </AuthenticatedLayout>
    );
}