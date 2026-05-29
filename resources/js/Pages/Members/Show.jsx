import DashboardLayout from "@/Layouts/DashboardLayout";
import { usePage } from "@inertiajs/react";

export default function Show({ member }) {

    const { auth } = usePage().props;

    return (
        <DashboardLayout user={auth.user}>

            <div className="bg-white p-6 rounded-2xl shadow">

                <h1 className="text-2xl font-bold mb-6">
                    Member Details
                </h1>

                <div className="space-y-4">

                    <div>
                        <span className="font-semibold">Name:</span>
                        <p>{member.name}</p>
                    </div>

                    <div>
                        <span className="font-semibold">Email:</span>
                        <p>{member.email}</p>
                    </div>

                    <div>
                        <span className="font-semibold">Phone:</span>
                        <p>{member.phone}</p>
                    </div>

                </div>

            </div>

        </DashboardLayout>
    );
}