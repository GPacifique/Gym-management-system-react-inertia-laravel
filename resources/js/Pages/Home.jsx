import React from "react";
import { Link, usePage } from "@inertiajs/react";
import ApplicationLogo from "@/Components/ApplicationLogo";
export default function Home() {
    const { auth, stats } = usePage().props;
    const user = auth?.user;

    return (
        <div className="min-h-screen bg-gray-50 text-gray-900">

            {/* ================= NAVBAR ================= */}
            <header className="bg-white border-b shadow-sm sticky top-0 z-50">
               
                <div className="max-w-7xl mx-auto flex justify-between items-center p-4">

                     <ApplicationLogo className="h-20 w-20 fill-current text-gray-500" />

                    <nav className="flex items-center gap-5 text-sm">

                        <a href="#features" className="text-gray-600 hover:text-blue-600">
                            Features
                        </a>

                        <a href="#pricing" className="text-gray-600 hover:text-blue-600">
                            Pricing
                        </a>

                        <a href="#contact" className="text-gray-600 hover:text-blue-600">
                            Contact
                        </a>

                        {user ? (
                            <Link
                                href="/dashboard"
                                className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                            >
                                Dashboard
                            </Link>
                        ) : (
                            <>
                                <Link href="/login" className="text-blue-600 font-medium">
                                    Login
                                </Link>

                                <Link
                                    href="/register"
                                    className="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                                >
                                    Get Started
                                </Link>
                            </>
                        )}

                    </nav>

                </div>
            </header>

            {/* ================= HERO ================= */}
            <section className="text-center py-24 px-4 bg-gradient-to-b from-blue-50 to-white">

                <h2 className="text-5xl font-bold mb-6 leading-tight">
                    Manage Gyms, Spa & Wellness Businesses in One System
                </h2>

                <p className="text-gray-600 max-w-2xl mx-auto mb-8 text-lg">
                    A complete SaaS platform to manage gyms, trainers, members,
                    subscriptions, bookings, payments, and multiple branches — all in one place.
                </p>

                {!user && (
                    <div className="flex justify-center gap-4">
                        <Link
                            href="/register"
                            className="bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700"
                        >
                            Start Free Trial
                        </Link>

                        <a
                            href="#features"
                            className="border border-gray-300 px-6 py-3 rounded-lg text-lg hover:border-blue-600"
                        >
                            Explore Features
                        </a>
                    </div>
                )}

            </section>

            {/* ================= STATS ================= */}
            <section className="max-w-6xl mx-auto grid md:grid-cols-3 gap-6 px-4 -mt-10">

                <StatCard title={stats?.businesses ?? 0} label="Gyms / Businesses" />
                <StatCard title={stats?.branches ?? 0} label="Branches" />
                <StatCard title={stats?.members ?? 0} label="Active Members" />

            </section>

            {/* ================= FEATURES ================= */}
            <section id="features" className="max-w-6xl mx-auto py-20 px-4">

                <h3 className="text-3xl font-bold text-center mb-12">
                    Powerful Features Built for Growth
                </h3>

                <div className="grid md:grid-cols-3 gap-6">

                    <Feature title="Multi-Gym SaaS" desc="Each gym has isolated data, dashboards, and users." />
                    <Feature title="Role-Based Access" desc="Super admin, owner, trainer, and member roles." />
                    <Feature title="Attendance System" desc="Track member check-ins and activity history." />
                    <Feature title="Subscriptions & Payments" desc="Manage billing, renewals, and revenue tracking." />
                    <Feature title="Smart Notifications" desc="SMS, Email & WhatsApp alerts for users." />
                    <Feature title="Analytics Dashboard" desc="Real-time insights on business performance." />

                </div>

            </section>

            {/* ================= CTA ================= */}
            <section className="bg-blue-600 text-white text-center py-20">

                <h3 className="text-3xl font-bold mb-4">
                    Ready to scale your fitness business?
                </h3>

                <p className="mb-8 text-blue-100">
                    Join modern gym owners using GymSaaS Pro to grow faster.
                </p>

                {!user && (
                    <Link
                        href="/register-business"
                        className="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100"
                    >
                        Create Business Account
                    </Link>
                )}

            </section>

            {/* ================= FOOTER ================= */}
            <footer className="text-center p-6 text-gray-500 text-sm">
                © {new Date().getFullYear()} GymSaaS Pro. All rights reserved.
            </footer>

        </div>
    );
}

/* ================= COMPONENTS ================= */

function Feature({ title, desc }) {
    return (
        <div className="bg-white p-6 rounded-xl shadow-sm border hover:shadow-md transition">
            <h4 className="font-bold text-lg mb-2">{title}</h4>
            <p className="text-gray-600 text-sm">{desc}</p>
        </div>
    );
}

function StatCard({ title, label }) {
    return (
        <div className="bg-white p-6 rounded-xl shadow text-center border">
            <h3 className="text-3xl font-bold text-blue-600">{title}</h3>
            <p className="text-gray-500 text-sm mt-1">{label}</p>
        </div>
    );
}