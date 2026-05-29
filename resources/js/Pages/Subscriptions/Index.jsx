import React from "react";
import { Link, usePage } from "@inertiajs/react";

export default function Index() {

    const { subscriptions } = usePage().props;

    return (
        <div className="p-6">

            <div className="flex justify-between mb-6">

                <h1 className="text-3xl font-bold">
                    Subscriptions
                </h1>

                <Link
                    href="/subscriptions/create"
                    className="bg-blue-600 text-white px-4 py-2 rounded"
                >
                    Create Subscription
                </Link>
            </div>

            <div className="bg-white rounded shadow overflow-x-auto">

                <table className="w-full">

                    <thead className="bg-gray-100">

                        <tr>

                            <th className="p-3 text-left">
                                Member
                            </th>

                            <th className="p-3 text-left">
                                Business
                            </th>

                            <th className="p-3 text-left">
                                Plan
                            </th>

                            <th className="p-3 text-left">
                                Price
                            </th>

                            <th className="p-3 text-left">
                                Status
                            </th>

                            <th className="p-3 text-left">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        {subscriptions.data.map((subscription) => (

                            <tr key={subscription.id}>

                                <td className="p-3">
                                    {subscription.member?.first_name}{" "}
                                    {subscription.member?.last_name}
                                </td>

                                <td className="p-3">
                                    {subscription.business?.name}
                                </td>

                                <td className="p-3">
                                    {subscription.name}
                                </td>

                                <td className="p-3">
                                    ${subscription.price}
                                </td>

                                <td className="p-3">
                                    {subscription.payment_status}
                                </td>

                                <td className="p-3 flex gap-2">

                                    <Link
                                        href={`/subscriptions/${subscription.id}`}
                                        className="bg-green-600 text-white px-3 py-1 rounded"
                                    >
                                        View
                                    </Link>

                                    <Link
                                        href={`/subscriptions/${subscription.id}/edit`}
                                        className="bg-yellow-500 text-white px-3 py-1 rounded"
                                    >
                                        Edit
                                    </Link>

                                </td>
                            </tr>

                        ))}

                    </tbody>
                </table>
            </div>
        </div>
    );
}