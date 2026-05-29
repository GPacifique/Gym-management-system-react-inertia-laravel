import React, { useState } from "react";
import { useForm, Link } from "@inertiajs/react";
import { Import } from "lucide-react";
import DashboardLayout from "@/Layouts/DashboardLayout";
export default function Create() {

    const { data, setData, post, processing, errors, reset } = useForm({
        name: "",
        email: "",
        phone: "",
        join_date: "",
        status: "active",
        profile_image: null,
    });

    const [preview, setPreview] = useState(null);

    const handleImage = (e) => {
        const file = e.target.files[0];

        setData("profile_image", file);

        if (file) {
            setPreview(URL.createObjectURL(file));
        }
    };

    const submit = (e) => {
        e.preventDefault();

        post(route("members.store"), {
            onSuccess: () => reset(),
        });
    };

    return (
        <DashboardLayout>
        <div className="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">

            {/* HEADER */}
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-2xl font-bold">
                    ➕ Create Member
                </h1>

                <Link
                    href={route("members.index")}
                    className="text-blue-600 hover:underline"
                >
                    ← Back
                </Link>
            </div>

            {/* FORM */}
            <form onSubmit={submit} className="space-y-5">

                {/* NAME */}
                <div>
                    <label className="block font-medium">Full Name</label>
                    <input
                        type="text"
                        value={data.name}
                        onChange={(e) => setData("name", e.target.value)}
                        className="w-full border rounded p-2"
                    />
                    {errors.name && (
                        <div className="text-red-500 text-sm">{errors.name}</div>
                    )}
                </div>

                {/* EMAIL */}
                <div>
                    <label className="block font-medium">Email</label>
                    <input
                        type="email"
                        value={data.email}
                        onChange={(e) => setData("email", e.target.value)}
                        className="w-full border rounded p-2"
                    />
                    {errors.email && (
                        <div className="text-red-500 text-sm">{errors.email}</div>
                    )}
                </div>

                {/* PHONE */}
                <div>
                    <label className="block font-medium">Phone</label>
                    <input
                        type="text"
                        value={data.phone}
                        onChange={(e) => setData("phone", e.target.value)}
                        className="w-full border rounded p-2"
                    />
                </div>

                {/* JOIN DATE */}
                <div>
                    <label className="block font-medium">Join Date</label>
                    <input
                        type="date"
                        value={data.join_date}
                        onChange={(e) => setData("join_date", e.target.value)}
                        className="w-full border rounded p-2"
                    />
                </div>

                {/* STATUS */}
                <div>
                    <label className="block font-medium">Status</label>
                    <select
                        value={data.status}
                        onChange={(e) => setData("status", e.target.value)}
                        className="w-full border rounded p-2"
                    >
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                {/* PROFILE IMAGE */}
                <div>
                    <label className="block font-medium">Profile Image</label>

                    <input
                        type="file"
                        onChange={handleImage}
                        className="w-full border rounded p-2"
                    />

                    {preview && (
                        <img
                            src={preview}
                            alt="Preview"
                            className="w-24 h-24 rounded-full mt-3 object-cover"
                        />
                    )}
                </div>

                {/* SUBMIT */}
                <button
                    type="submit"
                    disabled={processing}
                    className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    {processing ? "Saving..." : "Create Member"}
                </button>

            </form>
        </div>
        </DashboardLayout>
    );
}