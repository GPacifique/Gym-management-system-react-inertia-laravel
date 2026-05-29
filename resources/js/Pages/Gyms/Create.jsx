import DashboardLayout from "@/Layouts/DashboardLayout";
import { useForm, usePage } from "@inertiajs/react";

export default function Create() {
    const { users } = usePage().props;

    const { data, setData, post, processing } = useForm({
        name: "",
        email: "",
        phone: "",
        address: "",
        owner_id: ""
    });

    const submit = (e) => {
        e.preventDefault();
        post("/gyms");
    };

    return (
        <DashboardLayout>
            <div className="p-6 max-w-xl">
                <h1 className="text-xl font-bold mb-4">Create Gym</h1>

                <form onSubmit={submit} className="space-y-3">

                    <input
                        placeholder="Gym Name"
                        className="w-full border p-2"
                        onChange={(e) => setData("name", e.target.value)}
                    />

                    <input
                        placeholder="Email"
                        className="w-full border p-2"
                        onChange={(e) => setData("email", e.target.value)}
                    />

                    <input
                        placeholder="Phone"
                        className="w-full border p-2"
                        onChange={(e) => setData("phone", e.target.value)}
                    />

                    <textarea
                        placeholder="Address"
                        className="w-full border p-2"
                        onChange={(e) => setData("address", e.target.value)}
                    />

                    <select
                        className="w-full border p-2"
                        onChange={(e) => setData("owner_id", e.target.value)}
                    >
                        <option value="">Select Owner</option>
                        {users.map((u) => (
                            <option key={u.id} value={u.id}>
                                {u.name}
                            </option>
                        ))}
                    </select>

                    <button
                        disabled={processing}
                        className="bg-green-600 text-white px-4 py-2 rounded"
                    >
                        Create Gym
                    </button>
                </form>
            </div>
        </DashboardLayout>
    );
}