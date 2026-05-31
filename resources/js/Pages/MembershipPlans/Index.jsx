import DashboardLayout from "@/Layouts/DashboardLayout";
import { Link } from "@inertiajs/react";

export default function Index({ plans }) {
    return (
        <DashboardLayout>
            <div className="p-6">
                <div className="flex justify-between mb-4">
                    <h1 className="text-xl font-bold">Membership Plans</h1>

                    <Link
                        href="/membership-plans/create"
                        className="bg-blue-600 text-white px-4 py-2 rounded"
                    >
                        New Plan
                    </Link>
                </div>

                <table className="w-full bg-white shadow">
                    <thead>
                        <tr className="border-b">
                            <th className="p-2">Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        {plans.map((plan) => (
                            <tr key={plan.id} className="border-b">
                                <td className="p-2">{plan.name}</td>
                                <td>{plan.price}</td>
                                <td>{plan.duration_days} days</td>
                                <td>
                                    {plan.status ? "Active" : "Inactive"}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </DashboardLayout>
    );
}