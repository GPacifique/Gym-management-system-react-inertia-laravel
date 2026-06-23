import React, { useState } from "react";
import { router } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Create({ auth,
    errors,
    plans = [], branches = [] }) {
    const [values, setValues] = useState({
        first_name: "",
        last_name: "",
        phone: "",
        email: "",
        status: "active",
        branch_id: "", // optional only if allowed
        membership_plan_id: "",
    });

    const handleChange = (e) => {
        setValues({
            ...values,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();

        router.post(route("members.store"), values);
    };

    return (
        <DashboardLayout>
            <div className="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow">

                <h1 className="text-xl font-bold mb-4">
                    Create Member
                </h1>

                <form onSubmit={handleSubmit} className="space-y-4">

                    <input
                        name="first_name"
                        placeholder="First Name"
                        className="w-full border p-2"
                        onChange={handleChange}
                    />

                    <input
                        name="last_name"
                        placeholder="Last Name"
                        className="w-full border p-2"
                        onChange={handleChange}
                    />

                    <input
                        name="phone"
                        placeholder="Phone"
                        className="w-full border p-2"
                        onChange={handleChange}
                    />

                    <input
                        name="email"
                        placeholder="Email"
                        className="w-full border p-2"
                        onChange={handleChange}
                    />

                    {/* Only show if receptionist can choose branch */}
                    {branches.length > 1 && (
                        <select
                            name="branch_id"
                            className="w-full border p-2"
                            onChange={handleChange}
                        >
                            <option value="">Select Branch</option>
                            {branches.map((b) => (
                                <option key={b.id} value={b.id}>
                                    {b.name}
                                </option>
                            ))}
                        </select>
                    )}

                    <select
                        name="status"
                        className="w-full border p-2"
                        onChange={handleChange}
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                    {/* Membership Plan */}
<div>
    <label className="text-sm font-medium">
        Membership Plan
    </label>

    <select
        name="membership_plan_id"
        value={values.membership_plan_id}
        onChange={handleChange}
        className="w-full border p-2 rounded"
        required
    >
        <option value="">Select Plan</option>

        {plans.map((plan) => (
            <option key={plan.id} value={plan.id}>
                {plan.name} - {plan.price}
            </option>
        ))}
    </select>
</div>

                    <button className="bg-blue-600 text-white px-4 py-2 rounded">
                        Save Member
                    </button>

                </form>
            </div>
        </DashboardLayout>
    );
}