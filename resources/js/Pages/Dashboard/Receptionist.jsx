import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard() {
    const { auth } = usePage().props;

    return (
        <DashboardLayout user={auth.user}>
            <Head title="Reception Dashboard" />

            <h1 className="text-3xl font-bold">Reception Dashboard</h1>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <Stat title="New Registrations" value="0" />
                <Stat title="Check-ins Today" value="0" />
                <Stat title="Pending Payments" value="0" />
            </div>
        </DashboardLayout>
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