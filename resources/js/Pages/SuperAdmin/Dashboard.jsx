import DashboardLayout from "@/Layouts/DashboardLayout";
import { Head, usePage } from "@inertiajs/react";

export default function Dashboard() {
    const { auth } = usePage().props;

    return (
        <DashboardLayout user={auth.user}>
            <Head title="Super Admin Dashboard" />

            <h1 className="text-2xl font-bold">
                Super Admin Dashboard
            </h1>

            <p>Welcome, {auth.user.name}</p>
        </DashboardLayout>
    );
}