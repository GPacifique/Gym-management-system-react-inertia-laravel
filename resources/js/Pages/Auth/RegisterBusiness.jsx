import React from "react";
import { useForm } from "@inertiajs/react";

export default function RegisterBusiness() {

    const { data, setData, post, processing } = useForm({
        business_name: "",
        email: "",
        phone: "",
        password: "",
    });

    function submit(e) {
        e.preventDefault();
        post("/register-business");
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">

            <form onSubmit={submit} className="bg-white p-6 rounded shadow w-96">

                <h1 className="text-xl font-bold mb-4">
                    Register Your Business
                </h1>

                <input
                    placeholder="Business Name"
                    className="w-full border p-2 mb-2"
                    onChange={(e) => setData("business_name", e.target.value)}
                />

                <input
                    placeholder="Email"
                    className="w-full border p-2 mb-2"
                    onChange={(e) => setData("email", e.target.value)}
                />

                <input
                    placeholder="Phone"
                    className="w-full border p-2 mb-2"
                    onChange={(e) => setData("phone", e.target.value)}
                />

                <input
                    type="password"
                    placeholder="Password"
                    className="w-full border p-2 mb-4"
                    onChange={(e) => setData("password", e.target.value)}
                />

                <button
                    disabled={processing}
                    className="bg-blue-600 text-white w-full p-2"
                >
                    Create Business
                </button>

            </form>

        </div>
    );
}