import React from "react";
import { usePage } from "@inertiajs/react";

export default function Show() {

    const { business } = usePage().props;

    return (
        <div className="max-w-5xl mx-auto p-6">

            {business.cover_image && (
                <img
                    src={`/storage/${business.cover_image}`}
                    className="w-full h-96 object-cover rounded"
                />
            )}

            <h1 className="text-4xl font-bold mt-6">
                {business.name}
            </h1>

            <p className="mt-4 text-gray-700">
                {business.description}
            </p>

        </div>
    );
}