import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard() {
    const { auth } = usePage().props;

    return (
        <DashboardLayout user={auth.user}>
            <Head title="Trainer Dashboard" />

            <h1 className="text-3xl font-bold">Trainer Dashboard</h1>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <Stat title="My Clients" value="0" />
                <Stat title="Today Sessions" value="0" />
                <Stat title="Progress Reports" value="0" />
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