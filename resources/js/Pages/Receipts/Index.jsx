import DashboardLayout from "@/Layouts/DashboardLayout";
import { Link } from "@inertiajs/react";

export default function Index({ receipts }) {
    return (
        <DashboardLayout>
            <div className="p-6">

                <h1 className="text-xl font-bold mb-4">
                    Receipts
                </h1>

                <table className="w-full bg-white shadow">
                    <thead>
                        <tr>
                            <th>Receipt #</th>
                            <th>Member</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        {receipts.map((r) => (
                            <tr key={r.id}>
                                <td>{r.receipt_number}</td>
                                <td>{r.payment?.member?.first_name}</td>
                                <td>{r.payment?.amount}</td>
                                <td>
                                    <Link
                                        href={`/receipts/${r.id}`}
                                        className="text-blue-600"
                                    >
                                        View
                                    </Link>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>

            </div>
        </DashboardLayout>
    );
}