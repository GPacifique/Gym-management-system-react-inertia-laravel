import React from "react";
import { useForm, usePage } from "@inertiajs/react";

export default function Edit() {

    const { business } = usePage().props;

    const { data, setData, post, processing } = useForm({
        _method: "put",
        name: business.name || "",
        logo: null,
        cover_image: null,
        email: business.email || "",
        phone: business.phone || "",
        website: business.website || "",
        country: business.country || "",
        city: business.city || "",
        address: business.address || "",
        description: business.description || "",
        type: business.type || "",
        is_active: business.is_active,
    });

    const submit = (e) => {
        e.preventDefault();

        post(`/businesses/${business.id}`);
    };

    return (
        <div className="max-w-3xl mx-auto p-6">

            <h1 className="text-3xl font-bold mb-6">
                Edit Business
            </h1>

            <form onSubmit={submit} className="space-y-4">

                <input
                    type="text"
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <textarea
                    value={data.description}
                    onChange={(e) => setData("description", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <button
                    disabled={processing}
                    className="bg-blue-600 text-white px-6 py-3 rounded"
                >
                    Update Business
                </button>

            </form>
        </div>
    );
}