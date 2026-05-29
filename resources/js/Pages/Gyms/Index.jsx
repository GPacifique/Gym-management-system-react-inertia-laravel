import DashboardLayout from "@/Layouts/DashboardLayout";
import { Link, usePage } from "@inertiajs/react";

export default function Index() {
    const { gyms } = usePage().props;

    return (
        <DashboardLayout>
            <div className="p-6">
                <div className="flex justify-between mb-4">
                    <h1 className="text-xl font-bold">Gyms</h1>
                    <Link href="/gyms/create" className="bg-blue-500 text-white px-4 py-2 rounded">
                        Create Gym
                    </Link>
                </div>

                <table className="w-full border">
                    <thead>
                        <tr className="bg-gray-100">
                            <th>Name</th>
                            <th>Owner</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        {gyms.map((gym) => (
                            <tr key={gym.id} className="border-t">
                                <td>{gym.name}</td>
                                <td>{gym.owner?.name || "None"}</td>
                                <td>{gym.phone}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </DashboardLayout>
    );
}