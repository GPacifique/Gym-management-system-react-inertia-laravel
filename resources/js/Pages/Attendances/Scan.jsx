import React from "react";
import { useForm } from "@inertiajs/react";

export default function Scan() {

    const { data, setData, post, processing } = useForm({
        member_code: "",
    });

    const submit = (e) => {
        e.preventDefault();

        post("/attendance/check-in");
    };

    return (
        <div className="max-w-lg mx-auto p-6">

            <div className="bg-white rounded shadow p-6">

                <h1 className="text-3xl font-bold mb-6 text-center">
                    QR Check-In
                </h1>

                <form onSubmit={submit}>

                    <input
                        type="text"
                        placeholder="Scan QR Code"
                        value={data.member_code}
                        onChange={(e) =>
                            setData(
                                "member_code",
                                e.target.value
                            )
                        }
                        className="w-full border p-4 rounded"
                    />

                    <button
                        disabled={processing}
                        className="w-full bg-blue-600 text-white p-4 rounded mt-4"
                    >
                        Check In
                    </button>

                </form>
            </div>
        </div>
    );
}