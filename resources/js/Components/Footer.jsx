import React from "react";
import { Link } from "@inertiajs/react";

export default function Footer() {
    return (
        <footer className="bg-gray-900 text-gray-300 mt-10">
            <div className="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">

                {/* Brand */}
                <div>
                    <h2 className="text-white text-lg font-bold">
                        Gym SaaS
                    </h2>
                    <p className="text-sm mt-3 text-gray-400">
                        Smart gym management system for members, trainers, and owners.
                        Manage subscriptions, sessions, and payments in one place.
                    </p>
                </div>

                {/* Quick Links */}
                <div>
                    <h3 className="text-white font-semibold mb-3">Quick Links</h3>
                    <ul className="space-y-2 text-sm">
                        <li><Link href="/" className="hover:text-white">Home</Link></li>
                        <li><Link href="/dashboard" className="hover:text-white">Dashboard</Link></li>
                        <li><Link href="/pos" className="hover:text-white">POS</Link></li>
                        <li><Link href="/members" className="hover:text-white">Members</Link></li>
                    </ul>
                </div>

                {/* Features */}
                <div>
                    <h3 className="text-white font-semibold mb-3">Features</h3>
                    <ul className="space-y-2 text-sm">
                        <li>Subscriptions</li>
                        <li>Trainer Management</li>
                        <li>Attendance Tracking</li>
                        <li>Analytics Dashboard</li>
                    </ul>
                </div>

                {/* Contact */}
                <div>
                    <h3 className="text-white font-semibold mb-3">Contact</h3>
                    <ul className="space-y-2 text-sm">
                        <li>Email: support@gymsaas.com</li>
                        <li>Phone: +250 7XX XXX XXX</li>
                        <li>Location: Kigali, Rwanda</li>
                    </ul>
                </div>
            </div>

            {/* Bottom Bar */}
            <div className="border-t border-gray-800 mt-6">
                <div className="max-w-7xl mx-auto px-6 py-4 flex flex-col md:flex-row justify-between text-sm text-gray-500">
                    <p>© {new Date().getFullYear()} Gym SaaS. All rights reserved.</p>

                    <div className="flex gap-4 mt-2 md:mt-0">
                        <Link href="/privacy" className="hover:text-white">
                            Privacy Policy
                        </Link>
                        <Link href="/terms" className="hover:text-white">
                            Terms
                        </Link>
                    </div>
                </div>
            </div>
        </footer>
    );
}