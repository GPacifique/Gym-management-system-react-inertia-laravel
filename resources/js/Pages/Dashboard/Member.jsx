import DashboardLayout from "@/Layouts/DashboardLayout";
import DashboardCharts from "@/Components/GymCharts";

export default function Member() {
    return (
        <DashboardLayout>
        <div className="p-6">
            <h1 className="text-3xl font-bold">
                Member Dashboard
            </h1>

            <p className="mt-4 text-gray-600">
                Welcome to Gym SaaS System.
            </p>
            <DashboardCharts/>
        </div>
        </DashboardLayout>
    );
}