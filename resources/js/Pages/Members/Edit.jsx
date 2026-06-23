import React, { useState } from "react";
import { router } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Edit({ member, plans = [], membership }) {
    const [values, setValues] = useState({
        first_name: member.first_name || "",
        last_name: member.last_name || "",
        phone: member.phone || "",
        email: member.email || "",
        status: member.status || "active",
        membership_plan_id: membership?.membership_plan_id || "",
    });

    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        setValues({
            ...values,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setLoading(true);

        router.put(route("members.update", member.id), values, {
            onFinish: () => setLoading(false),
        });
    };

    return (
        <DashboardLayout>
            <div className="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow space-y-6">

                <h1 className="text-xl font-bold">
                    Edit Member
                </h1>

                {/* MEMBER INFO */}
                <form onSubmit={handleSubmit} className="space-y-4">

                    <div className="grid grid-cols-2 gap-4">

                        <input
                            name="first_name"
                            value={values.first_name}
                            onChange={handleChange}
                            placeholder="First Name"
                            className="border p-2 rounded"
                        />

                        <input
                            name="last_name"
                            value={values.last_name}
                            onChange={handleChange}
                            placeholder="Last Name"
                            className="border p-2 rounded"
                        />

                    </div>

                    <input
                        name="phone"
                        value={values.phone}
                        onChange={handleChange}
                        placeholder="Phone"
                        className="w-full border p-2 rounded"
                    />

                    <input
                        name="email"
                        value={values.email}
                        onChange={handleChange}
                        placeholder="Email"
                        className="w-full border p-2 rounded"
                    />

                    <select
                        name="status"
                        value={values.status}
                        onChange={handleChange}
                        className="w-full border p-2 rounded"
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                        <option value="expired">Expired</option>
                    </select>

                    {/* MEMBERSHIP SECTION */}
                    <div className="border-t pt-4 mt-4">

                        <h2 className="font-semibold mb-2">
                            Membership Plan
                        </h2>

                        {membership && (
                            <div className="mb-3 text-sm text-gray-600">
                                Current Plan:{" "}
                                <span className="font-medium">
                                    {membership.plan?.name ?? "N/A"}
                                </span>
                                <br />
                                Expires:{" "}
                                <span className="font-medium">
                                    {membership.end_date}
                                </span>
                            </div>
                        )}

                        <select
                            name="membership_plan_id"
                            value={values.membership_plan_id}
                            onChange={handleChange}
                            className="w-full border p-2 rounded"
                        >
                            <option value="">-- Select Plan --</option>

                            {plans.map((plan) => (
                                <option key={plan.id} value={plan.id}>
                                    {plan.name} - {plan.price}
                                </option>
                            ))}
                        </select>
                    </div>

                    {/* SUBMIT */}
                    <div className="pt-4">
                        <button
                            disabled={loading}
                            className="bg-blue-600 text-white px-4 py-2 rounded"
                        >
                            {loading ? "Updating..." : "Update Member"}
                        </button>
                    </div>

                </form>
            </div>
        </DashboardLayout>
    );
}