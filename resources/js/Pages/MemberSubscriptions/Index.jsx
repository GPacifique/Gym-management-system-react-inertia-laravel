import DashboardLayout from "@/Layouts/DashboardLayout";
import { Link } from "@inertiajs/react";

export default function Index({ subscriptions }) {
    return (
        <DashboardLayout>
            <div className="p-6">

                <div className="flex justify-between mb-4">
                    <h1 className="text-xl font-bold">Subscriptions</h1>

                    <Link
                        href="/member-subscriptions/create"
                        className="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        Assign Plan
                    </Link>
                </div>

                <table className="w-full bg-white shadow">
                    <thead>
                        <tr className="border-b">
                            <th>Member</th>
                            <th>Plan</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        {subscriptions.map((sub) => (
                            <tr key={sub.id} className="border-b">
                                <td>{sub.member?.first_name}</td>
                                <td>{sub.plan?.name}</td>
                                <td>{sub.start_date}</td>
                                <td>{sub.end_date}</td>
                                <td>
                                    {sub.status}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>

            </div>
        </DashboardLayout>
    );
}