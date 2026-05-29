import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage } from "@inertiajs/react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";

export default function Dashboard() {
    const { auth } = usePage().props;

    return (
        <AuthenticatedLayout>
        <DashboardLayout user={auth.user}>
            <Head title="Manager Dashboard" />

            <h1 className="text-3xl font-bold">Manager Dashboard</h1>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <Stat title="Daily Check-ins" value="0" />
                <Stat title="Active Members" value="0" />
                <Stat title="Staff Present" value="0" />
            </div>
        </DashboardLayout>
         </AuthenticatedLayout>
    );
}

function Stat({ title, value }) {
    return (
        <div className="bg-white p-4 rounded-xl shadow">
            <p className="text-gray-500 text-sm">{title}</p>
            <h2 className="text-2xl font-bold">{value}</h2>
        </div>
       
    );
}