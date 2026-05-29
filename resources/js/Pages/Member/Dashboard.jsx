import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard() {
    const { auth } = usePage().props;
    const user = auth.user;

    return (
        <DashboardLayout user={user}>
            <Head title="Member Dashboard" />

            <h1 className="text-3xl font-bold">My Fitness Dashboard</h1>

            <p className="text-gray-500">Welcome back {user.name}</p>

            <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <Stat title="My Membership" value="Active" />
                <Stat title="Attendance" value="0 days" />
                <Stat title="Next Payment" value="--" />
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