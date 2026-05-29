import React from "react";
import { Link, usePage } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Index() {
    const { members, auth } = usePage().props;

    return (
        <DashboardLayout>
        <div className="p-6 space-y-6">

            {/* HEADER */}
            <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h1 className="text-3xl font-bold text-gray-800">
                        Members
                    </h1>

                    <p className="text-gray-500 mt-1">
                        Manage gym members and attendance
                    </p>

                    {/* 🔥 GYM CONTEXT (NEW) */}
                    <p className="text-xs text-blue-500 mt-1">
                        Gym ID: {auth?.user?.default_gym_id ?? "Not Assigned"}
                    </p>
                </div>

                <Link
                    href={route("members.create")}
                    className="bg-blue-600 hover:bg-blue-700 transition text-white px-5 py-3 rounded-xl shadow"
                >
                    Add Member
                </Link>

            </div>

            {/* MEMBERS GRID */}
            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                {members.data?.map((member) => (

                    <div
                        key={member.id}
                        className="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden border border-gray-100"
                    >

                        {/* TOP */}
                        <div className="p-6">

                            {/* PHOTO */}
                            <div className="flex justify-center">

                                {member.photo ? (
                                    <img
                                        src={`/storage/${member.photo}`}
                                        alt={member.first_name}
                                        className="w-28 h-28 rounded-full object-cover border-4 border-blue-100"
                                    />
                                ) : (
                                    <div className="w-28 h-28 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-500">
                                        {member.first_name?.charAt(0)}
                                    </div>
                                )}

                            </div>

                            {/* NAME */}
                            <div className="text-center mt-4">

                                <h2 className="text-xl font-bold text-gray-800">
                                    {member.first_name} {member.last_name}
                                </h2>

                                <p className="text-sm text-gray-500 mt-1">
                                    {member.email}
                                </p>

                                {/* 🔥 GYM DEBUG (optional but useful) */}
                                <p className="text-xs text-gray-400 mt-1">
                                    Gym ID: {member.gym_id}
                                </p>

                            </div>

                            {/* MEMBERSHIP */}
                            <div className="mt-5 flex items-center justify-center">

                                <span className="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm font-medium">
                                    {member.membership_type}
                                </span>

                            </div>

                            {/* DETAILS */}
                            <div className="mt-6 space-y-3 text-sm">

                                <div className="flex justify-between">
                                    <span className="text-gray-500">Phone</span>
                                    <span className="font-medium text-gray-800">
                                        {member.phone ?? "N/A"}
                                    </span>
                                </div>

                                <div className="flex justify-between">
                                    <span className="text-gray-500">Gender</span>
                                    <span className="font-medium text-gray-800">
                                        {member.gender ?? "N/A"}
                                    </span>
                                </div>

                                <div className="flex justify-between">
                                    <span className="text-gray-500">Status</span>

                                    <span
                                        className={`px-3 py-1 rounded-full text-xs font-medium ${
                                            member.status === "active"
                                                ? "bg-green-100 text-green-700"
                                                : "bg-red-100 text-red-700"
                                        }`}
                                    >
                                        {member.status ?? "inactive"}
                                    </span>
                                </div>

                                <div className="flex justify-between">
                                    <span className="text-gray-500">Joined</span>
                                    <span className="font-medium text-gray-800">
                                        {member.created_at?.split("T")[0]}
                                    </span>
                                </div>

                            </div>

                        </div>

                        {/* ACTIONS */}
                        <div className="bg-gray-50 p-4 border-t">

                            <div className="grid grid-cols-2 gap-3">

                                <Link
                                    href={route("members.show", member.id)}
                                    className="bg-green-600 hover:bg-green-700 transition text-white text-center px-4 py-2 rounded-xl text-sm font-medium"
                                >
                                    View
                                </Link>

                                <Link
                                    href={route("members.edit", member.id)}
                                    className="bg-yellow-500 hover:bg-yellow-600 transition text-white text-center px-4 py-2 rounded-xl text-sm font-medium"
                                >
                                    Edit
                                </Link>

                            </div>

                            {/* ATTENDANCE */}
                            <Link
                                href={route("attendance.store")}
                                method="post"
                                data={{
                                    member_id: member.id,
                                    gym_id: auth?.user?.default_gym_id, // 🔥 SAFE ADDITION
                                }}
                                as="button"
                                className="w-full mt-3 bg-blue-600 hover:bg-blue-700 transition text-white py-3 rounded-xl font-medium"
                            >
                                Record Attendance
                            </Link>

                        </div>

                    </div>

                ))}

            </div>

            {/* EMPTY */}
            {members.data?.length === 0 && (
                <div className="bg-white rounded-2xl shadow p-10 text-center">
                    <h2 className="text-2xl font-bold text-gray-700">
                        No Members Found
                    </h2>
                    <p className="text-gray-500 mt-2">
                        Start by registering your first gym member.
                    </p>
                </div>
            )}

        </div>
        </DashboardLayout>
    );
}