import React from "react";
import { useForm, usePage } from "@inertiajs/react";

export default function Create() {

    const { businesses, members } = usePage().props;

    const { data, setData, post, processing } = useForm({
        business_id: "",
        member_id: "",
        name: "",
        description: "",
        price: "",
        duration: "",
        duration_type: "months",
        start_date: "",
        payment_status: "paid",
        payment_method: "",
        transaction_id: "",
        is_active: true,
    });

    const submit = (e) => {
        e.preventDefault();
        post("/subscriptions");
    };

    return (
        <div className="max-w-4xl mx-auto p-6">

            <h1 className="text-3xl font-bold mb-6">
                Create Subscription
            </h1>

            <form onSubmit={submit} className="space-y-4">

                <select
                    value={data.business_id}
                    onChange={(e) => setData("business_id", e.target.value)}
                    className="w-full border p-3 rounded"
                >
                    <option value="">
                        Select Business
                    </option>

                    {businesses.map((business) => (
                        <option
                            key={business.id}
                            value={business.id}
                        >
                            {business.name}
                        </option>
                    ))}
                </select>

                <select
                    value={data.member_id}
                    onChange={(e) => setData("member_id", e.target.value)}
                    className="w-full border p-3 rounded"
                >
                    <option value="">
                        Select Member
                    </option>

                    {members.map((member) => (
                        <option
                            key={member.id}
                            value={member.id}
                        >
                            {member.first_name} {member.last_name}
                        </option>
                    ))}
                </select>

                <input
                    type="text"
                    placeholder="Subscription Name"
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <input
                    type="number"
                    placeholder="Price"
                    value={data.price}
                    onChange={(e) => setData("price", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <button
                    disabled={processing}
                    className="bg-blue-600 text-white px-6 py-3 rounded"
                >
                    Save Subscription
                </button>

            </form>
        </div>
    );
}