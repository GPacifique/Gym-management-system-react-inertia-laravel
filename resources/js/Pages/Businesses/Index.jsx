import React from "react";
import { Link, usePage } from "@inertiajs/react";

export default function Index() {

    const { businesses } = usePage().props;

    return (
        <div className="p-6">

            <div className="flex justify-between mb-6">
                <h1 className="text-3xl font-bold">
                    Businesses
                </h1>

                <Link
                    href="/businesses/create"
                    className="bg-blue-600 text-white px-4 py-2 rounded"
                >
                    Create Business
                </Link>
            </div>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">

                {businesses.data.map((business) => (

                    <div
                        key={business.id}
                        className="bg-white rounded shadow overflow-hidden"
                    >

                        {business.cover_image && (
                            <img
                                src={`/storage/${business.cover_image}`}
                                className="w-full h-48 object-cover"
                            />
                        )}

                        <div className="p-4">

                            <h2 className="text-xl font-bold">
                                {business.name}
                            </h2>

                            <p className="text-gray-600">
                                {business.city}
                            </p>

                            <div className="flex gap-2 mt-4">

                                <Link
                                    href={`/businesses/${business.id}`}
                                    className="bg-green-600 text-white px-3 py-1 rounded"
                                >
                                    View
                                </Link>

                                <Link
                                    href={`/businesses/${business.id}/edit`}
                                    className="bg-yellow-500 text-white px-3 py-1 rounded"
                                >
                                    Edit
                                </Link>

                            </div>
                        </div>
                    </div>

                ))}

            </div>
        </div>
    );
}