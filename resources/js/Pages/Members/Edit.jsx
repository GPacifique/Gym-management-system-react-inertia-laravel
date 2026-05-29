import React from "react";
import { useForm, usePage } from "@inertiajs/react";

export default function Edit() {

    const { member, businesses } = usePage().props;

    const { data, setData, post, processing } = useForm({
        _method: "put",
        business_id: member.business_id,
        first_name: member.first_name,
        last_name: member.last_name,
        photo: null,
        email: member.email || "",
        phone: member.phone || "",
        membership_type: member.membership_type || "",
        notes: member.notes || "",
        is_active: member.is_active,
    });

    const submit = (e) => {
        e.preventDefault();

        post(`/members/${member.id}`);
    };

    return (
        <div className="max-w-3xl mx-auto p-6">

            <h1 className="text-3xl font-bold mb-6">
                Edit Member
            </h1>

            <form onSubmit={submit} className="space-y-4">

                <select
                    value={data.business_id}
                    onChange={(e) => setData("business_id", e.target.value)}
                    className="w-full border p-3 rounded"
                >
                    {businesses.map((business) => (
                        <option
                            key={business.id}
                            value={business.id}
                        >
                            {business.name}
                        </option>
                    ))}
                </select>

                <input
                    type="text"
                    value={data.first_name}
                    onChange={(e) => setData("first_name", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <input
                    type="text"
                    value={data.last_name}
                    onChange={(e) => setData("last_name", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <button
                    disabled={processing}
                    className="bg-blue-600 text-white px-6 py-3 rounded"
                >
                    Update Member
                </button>

            </form>
        </div>
    );
}