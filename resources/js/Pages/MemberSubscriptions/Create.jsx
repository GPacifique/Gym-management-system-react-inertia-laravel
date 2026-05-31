import DashboardLayout from "@/Layouts/DashboardLayout";
import { useForm } from "@inertiajs/react";

export default function Create({ members, plans }) {
    const { data, setData, post } = useForm({
        member_id: "",
        membership_plan_id: "",
    });

    function submit(e) {
        e.preventDefault();
        post("/member-subscriptions");
    }

    return (
        <DashboardLayout>
            <div className="p-6 max-w-xl">

                <h1 className="text-xl font-bold mb-4">
                    Assign Subscription
                </h1>

                <form onSubmit={submit}>

                    <select
                        className="w-full border p-2 mb-3"
                        onChange={(e) =>
                            setData("member_id", e.target.value)
                        }
                    >
                        <option>Select Member</option>
                        {members.map((m) => (
                            <option key={m.id} value={m.id}>
                                {m.first_name}
                            </option>
                        ))}
                    </select>

                    <select
                        className="w-full border p-2 mb-3"
                        onChange={(e) =>
                            setData("membership_plan_id", e.target.value)
                        }
                    >
                        <option>Select Plan</option>
                        {plans.map((p) => (
                            <option key={p.id} value={p.id}>
                                {p.name} - {p.price}
                            </option>
                        ))}
                    </select>

                    <button className="bg-blue-600 text-white px-4 py-2 rounded">
                        Assign
                    </button>

                </form>
            </div>
        </DashboardLayout>
    );
}