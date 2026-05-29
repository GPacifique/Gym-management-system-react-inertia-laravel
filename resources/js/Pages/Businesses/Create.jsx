import React from "react";
import { useForm } from "@inertiajs/react";

export default function Create() {

    const { data, setData, post, processing, errors } = useForm({
        name: "",
        logo: null,
        cover_image: null,
        email: "",
        phone: "",
        website: "",
        country: "",
        city: "",
        address: "",
        description: "",
        type: "",
        is_active: true,
    });

    const submit = (e) => {
        e.preventDefault();
        post("/businesses");
    };

    return (
        <div className="max-w-3xl mx-auto p-6">

            <h1 className="text-3xl font-bold mb-6">
                Create Business
            </h1>

            <form onSubmit={submit} className="space-y-4">

                <input
                    type="text"
                    placeholder="Business Name"
                    value={data.name}
                    onChange={(e) => setData("name", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <input
                    type="file"
                    onChange={(e) => setData("logo", e.target.files[0])}
                />

                <input
                    type="file"
                    onChange={(e) => setData("cover_image", e.target.files[0])}
                />

                <textarea
                    placeholder="Description"
                    value={data.description}
                    onChange={(e) => setData("description", e.target.value)}
                    className="w-full border p-3 rounded"
                />

                <button
                    disabled={processing}
                    className="bg-blue-600 text-white px-6 py-3 rounded"
                >
                    Save Business
                </button>

            </form>
        </div>
    );
}