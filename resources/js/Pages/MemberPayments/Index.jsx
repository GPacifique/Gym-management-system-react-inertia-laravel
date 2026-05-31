import DashboardLayout from "@/Layouts/DashboardLayout";
import { Link } from "@inertiajs/react";

export default function Index({ payments }) {
    return (
        <DashboardLayout>
            <div className="p-6">

                <div className="flex justify-between mb-4">
                    <h1 className="text-xl font-bold">Payments</h1>

                    <Link
                        href="/payments/create"
                        className="bg-purple-600 text-white px-4 py-2 rounded"
                    >
                        New Payment
                    </Link>
                </div>

                <table className="w-full bg-white shadow">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        {payments.map((p) => (
                            <tr key={p.id}>
                                <td>{p.member?.first_name}</td>
                                <td>{p.amount}</td>
                                <td>{p.payment_method}</td>
                                <td>{p.payment_date}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>

            </div>
        </DashboardLayout>
    );
}