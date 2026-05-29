import { Link, usePage } from "@inertiajs/react";
import AuthenticatedLayout from "./AuthenticatedLayout";

export default function DashboardLayout({ children }) {

    const page = usePage();

    const user = page.props.auth?.user;
    const currentUrl = page.url;

    const hasRole = (...roles) => {
        return roles.includes(user?.role);
    };

    const navLinkClass = (path) => {
        return `
            flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            ${
                currentUrl.startsWith(path)
                    ? "bg-blue-600 text-white shadow-lg"
                    : "text-gray-300 hover:bg-gray-800 hover:text-white"
            }
        `;
    };

    return (
        <AuthenticatedLayout>
        <div className="min-h-screen flex bg-gray-100">

            {/* SIDEBAR */}
            <aside className="w-72 bg-gray-900 text-white flex flex-col">

                {/* HEADER */}
                <div className="p-6 border-b border-gray-800">

                    <h1 className="text-3xl font-bold">
                        Gym SaaS
                    </h1>

                    <p className="text-gray-400 text-sm mt-2">
                        Gym Management System
                    </p>

                </div>

                {/* USER */}
                <div className="px-6 py-5 border-b border-gray-800">

                    <h2 className="font-semibold text-lg">
                        {user?.name}
                    </h2>

                    <p className="text-sm text-gray-400 capitalize">
                        {user?.role?.replace("_", " ")}
                    </p>

                </div>

                {/* NAVIGATION */}
                <nav className="flex-1 overflow-y-auto p-5 space-y-2">

                    {/* COMMON */}
                    <Link
                        href={route("dashboard")}
                        className={navLinkClass("/dashboard")}
                    >
                        📊 Dashboard
                    </Link>

                    <Link
                        href={route("profile.edit")}
                        className={navLinkClass("/profile")}
                    >
                        👤 Profile
                    </Link>

                    {/* SUPER ADMIN */}
                    {hasRole("super_admin") && (
                        <>
                            <div className="pt-4 pb-2 text-xs uppercase text-gray-500 tracking-wider">
                                Super Admin
                            </div>

                            <Link
                                href={route("branches.index")}
                                className={navLinkClass("/branches")}
                            >
                                🏢 Branches
                            </Link>

                            <Link
                                href={route("members.index")}
                                className={navLinkClass("/members")}
                            >
                                👥 Members
                            </Link>

                            <Link
                                href={route("analytics.index")}
                                className={navLinkClass("/analytics")}
                            >
                                📈 Analytics
                            </Link>

                            <Link
                                href={route("security.index")}
                                className={navLinkClass("/security")}
                            >
                                🔐 Security
                            </Link>
                        </>
                    )}

                    {/* BUSINESS OWNER */}
                    {hasRole("business_owner") && (
                        <>
                            <div className="pt-4 pb-2 text-xs uppercase text-gray-500 tracking-wider">
                                Business Owner
                            </div>

                            <Link
                                href={route("staff.index")}
                                className={navLinkClass("/staff")}
                            >
                                👨‍💼 Staff
                            </Link>

                            <Link
                                href={route("trainers.index")}
                                className={navLinkClass("/trainers")}
                            >
                                💪 Trainers
                            </Link>

                            <Link
                                href={route("members.index")}
                                className={navLinkClass("/members")}
                            >
                                👥 Members
                            </Link>

                            <Link
                                href={route("subscriptions.index")}
                                className={navLinkClass("/subscriptions")}
                            >
                                📦 Subscriptions
                            </Link>

                            <Link
                                href={route("payments.index")}
                                className={navLinkClass("/payments")}
                            >
                                💳 Payments
                            </Link>

                            <Link
                                href={route("workout-programs.index")}
                                className={navLinkClass("/workout-programs")}
                            >
                                🏋️ Workout Programs
                            </Link>

                            <Link
                                href={route("nutrition-plans.index")}
                                className={navLinkClass("/nutrition-plans")}
                            >
                                🥗 Nutrition Plans
                            </Link>

                            <Link
                                href={route("pos.index")}
                                className={navLinkClass("/pos")}
                            >
                                🛒 POS
                            </Link>
                        </>
                    )}

                    {/* MANAGER */}
                    {hasRole("manager") && (
                        <>
                            <div className="pt-4 pb-2 text-xs uppercase text-gray-500 tracking-wider">
                                Manager
                            </div>

                            <Link
                                href={route("members.index")}
                                className={navLinkClass("/members")}
                            >
                                👥 Members
                            </Link>

                            <Link
                                href={route("attendance.index")}
                                className={navLinkClass("/attendance")}
                            >
                                📅 Attendance
                            </Link>

                            <Link
                                href={route("bookings.index")}
                                className={navLinkClass("/bookings")}
                            >
                                📖 Bookings
                            </Link>
                        </>
                    )}

                    {/* RECEPTIONIST */}
                    {hasRole("receptionist") && (
                        <>
                            <div className="pt-4 pb-2 text-xs uppercase text-gray-500 tracking-wider">
                                Reception
                            </div>

                            <Link
                                href={route("members.index")}
                                className={navLinkClass("/members")}
                            >
                                👥 Members
                            </Link>

                            <Link
                                href={route("attendance.index")}
                                className={navLinkClass("/attendance")}
                            >
                                📅 Attendance
                            </Link>

                            <Link
                                href={route("payments.index")}
                                className={navLinkClass("/payments")}
                            >
                                💳 Payments
                            </Link>

                            <Link
                                href={route("bookings.index")}
                                className={navLinkClass("/bookings")}
                            >
                                📖 Bookings
                            </Link>
                        </>
                    )}

                    {/* TRAINER */}
                    {hasRole("trainer") && (
                        <>
                            <div className="pt-4 pb-2 text-xs uppercase text-gray-500 tracking-wider">
                                Trainer
                            </div>

                            <Link
                                href={route("members.index")}
                                className={navLinkClass("/members")}
                            >
                                👥 Members
                            </Link>

                            <Link
                                href={route("workout-programs.index")}
                                className={navLinkClass("/workout-programs")}
                            >
                                🏋️ Workouts
                            </Link>

                            <Link
                                href={route("nutrition-plans.index")}
                                className={navLinkClass("/nutrition-plans")}
                            >
                                🥗 Nutrition
                            </Link>
                        </>
                    )}

                    {/* MEMBER */}
                    {hasRole("member") && (
                        <>
                            <div className="pt-4 pb-2 text-xs uppercase text-gray-500 tracking-wider">
                                Member
                            </div>

                            <Link
                                href={route("bookings.mine")}
                                className={navLinkClass("/my-bookings")}
                            >
                                📖 My Bookings
                            </Link>

                            <Link
                                href={route("subscriptions.mine")}
                                className={navLinkClass("/my-subscriptions")}
                            >
                                📦 My Subscriptions
                            </Link>
                        </>
                    )}

                </nav>

                {/* FOOTER */}
                <div className="p-5 border-t border-gray-800">

                    <Link
                        href={route("logout")}
                        method="post"
                        as="button"
                        className="w-full bg-red-500 hover:bg-red-600 py-3 rounded-xl font-semibold transition"
                    >
                        Logout
                    </Link>

                </div>

            </aside>

            {/* MAIN */}
            <main className="flex-1 overflow-y-auto p-6">
                {children}
            </main>

        </div>
        </AuthenticatedLayout>
    );
}