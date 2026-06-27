import DashboardLayout from "@/Layouts/DashboardLayout";
import { useForm } from "@inertiajs/react";

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        duration_days: "",
        price: "",
        description: "",
        status: "active",
    });

    const submit = (e) => {
        e.preventDefault();
        post(route("membership-plans.store"));
    };

    return (
        <DashboardLayout>
            <div className="p-6 max-w-3xl mx-auto">
                <div className="flex items-center justify-between mb-6">
                    <h1 className="text-2xl font-bold">Create Membership Plan</h1>
                    <a
                        href={route("membership-plans.index")}
                        className="text-sm text-blue-600 hover:underline"
                    >
                        Back to Plans
                    </a>
                </div>

                <form onSubmit={submit} className="space-y-4 bg-white shadow rounded-lg p-6">
                    <div>
                        <label className="block text-sm font-medium text-slate-700">Name</label>
                        <input
                            type="text"
                            value={data.name}
                            onChange={(e) => setData("name", e.target.value)}
                            className="w-full border rounded p-3 mt-1"
                        />
                        {errors.name && (
                            <p className="text-sm text-red-600 mt-1">{errors.name}</p>
                        )}
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label className="block text-sm font-medium text-slate-700">Price</label>
                            <input
                                type="number"
                                step="0.01"
                                value={data.price}
                                onChange={(e) => setData("price", e.target.value)}
                                className="w-full border rounded p-3 mt-1"
                            />
                            {errors.price && (
                                <p className="text-sm text-red-600 mt-1">{errors.price}</p>
                            )}
                        </div>

                        <div>
                            <label className="block text-sm font-medium text-slate-700">Duration (days)</label>
                            <input
                                type="number"
                                value={data.duration_days}
                                onChange={(e) => setData("duration_days", e.target.value)}
                                className="w-full border rounded p-3 mt-1"
                            />
                            {errors.duration_days && (
                                <p className="text-sm text-red-600 mt-1">{errors.duration_days}</p>
                            )}
                        </div>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-slate-700">Description</label>
                        <textarea
                            value={data.description}
                            onChange={(e) => setData("description", e.target.value)}
                            className="w-full border rounded p-3 mt-1 min-h-[120px]"
                        />
                        {errors.description && (
                            <p className="text-sm text-red-600 mt-1">{errors.description}</p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-slate-700">Status</label>
                        <select
                            value={data.status}
                            onChange={(e) => setData("status", e.target.value)}
                            className="w-full border rounded p-3 mt-1"
                        >
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        {errors.status && (
                            <p className="text-sm text-red-600 mt-1">{errors.status}</p>
                        )}
                    </div>

                    <div className="flex justify-end">
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 disabled:opacity-50"
                        >
                            Save Plan
                        </button>
                    </div>
                </form>
            </div>
        </DashboardLayout>
    );
}
