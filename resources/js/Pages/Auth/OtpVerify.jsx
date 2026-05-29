import React from "react";
import { useForm } from "@inertiajs/react";

export default function OtpVerify() {

    const { data, setData, post, processing, errors } = useForm({
        otp: ""
    });

    function submit(e) {
        e.preventDefault();
        post("/verify-otp");
    }

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">

            <form onSubmit={submit} className="bg-white p-6 rounded shadow w-80">

                <h1 className="text-lg font-bold mb-3">
                    Verify OTP
                </h1>

                <input
                    placeholder="Enter OTP"
                    className="w-full border p-2 mb-2"
                    onChange={(e) => setData("otp", e.target.value)}
                />

                {errors.otp && (
                    <p className="text-red-500 text-sm">{errors.otp}</p>
                )}

                <button
                    disabled={processing}
                    className="bg-green-600 text-white w-full p-2 mt-2"
                >
                    Verify
                </button>

            </form>

        </div>
    );
}