import React from "react";
import { useForm, Link } from "@inertiajs/react";
import DashboardLayout from "@/Layouts/DashboardLayout";

export default function Create() {
    const { data, setData, post, processing, errors } = useForm({
        name: "",
        slug: "",
        email: "",
        phone: "",
        country: "",
        city: "",
        address: "",
        logo: null,
        status: "active",
        owner_id: "",
        subscription_plan_id: "",
        subscription_expires_at: "",
    });

    const handleSubmit = (e) => {
        e.preventDefault();

        post(route("superadmin.gyms.store"), {
            forceFormData: true,
        });
    };

    return (
        <DashboardLayout>
        <div className="container py-4">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2>Create Gym</h2>

                <Link
                    href={route("superadmin.gyms.index")}
                    className="btn btn-secondary"
                >
                    Back
                </Link>
            </div>

            <div className="card shadow-sm">
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="row">
                            {/* Gym Name */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">
                                    Gym Name
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={data.name}
                                    onChange={(e) =>
                                        setData("name", e.target.value)
                                    }
                                />
                                {errors.name && (
                                    <div className="text-danger">
                                        {errors.name}
                                    </div>
                                )}
                            </div>

                            {/* Slug */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Slug</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={data.slug}
                                    onChange={(e) =>
                                        setData("slug", e.target.value)
                                    }
                                />
                                {errors.slug && (
                                    <div className="text-danger">
                                        {errors.slug}
                                    </div>
                                )}
                            </div>

                            {/* Email */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Email</label>
                                <input
                                    type="email"
                                    className="form-control"
                                    value={data.email}
                                    onChange={(e) =>
                                        setData("email", e.target.value)
                                    }
                                />
                                {errors.email && (
                                    <div className="text-danger">
                                        {errors.email}
                                    </div>
                                )}
                            </div>

                            {/* Phone */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Phone</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={data.phone}
                                    onChange={(e) =>
                                        setData("phone", e.target.value)
                                    }
                                />
                                {errors.phone && (
                                    <div className="text-danger">
                                        {errors.phone}
                                    </div>
                                )}
                            </div>

                            {/* Country */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Country</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={data.country}
                                    onChange={(e) =>
                                        setData("country", e.target.value)
                                    }
                                />
                            </div>

                            {/* City */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">City</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    value={data.city}
                                    onChange={(e) =>
                                        setData("city", e.target.value)
                                    }
                                />
                            </div>

                            {/* Address */}
                            <div className="col-md-12 mb-3">
                                <label className="form-label">Address</label>
                                <textarea
                                    className="form-control"
                                    rows="3"
                                    value={data.address}
                                    onChange={(e) =>
                                        setData("address", e.target.value)
                                    }
                                />
                            </div>

                            {/* Logo */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Logo</label>
                                <input
                                    type="file"
                                    className="form-control"
                                    onChange={(e) =>
                                        setData("logo", e.target.files[0])
                                    }
                                />
                                {errors.logo && (
                                    <div className="text-danger">
                                        {errors.logo}
                                    </div>
                                )}
                            </div>

                            {/* Status */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">Status</label>
                                <select
                                    className="form-select"
                                    value={data.status}
                                    onChange={(e) =>
                                        setData("status", e.target.value)
                                    }
                                >
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>

                            {/* Owner */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">
                                    Owner ID
                                </label>
                                <input
                                    type="number"
                                    className="form-control"
                                    value={data.owner_id}
                                    onChange={(e) =>
                                        setData("owner_id", e.target.value)
                                    }
                                />
                            </div>

                            {/* Subscription Plan */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">
                                    Subscription Plan ID
                                </label>
                                <input
                                    type="number"
                                    className="form-control"
                                    value={data.subscription_plan_id}
                                    onChange={(e) =>
                                        setData(
                                            "subscription_plan_id",
                                            e.target.value
                                        )
                                    }
                                />
                            </div>

                            {/* Expiry Date */}
                            <div className="col-md-6 mb-3">
                                <label className="form-label">
                                    Subscription Expiry
                                </label>
                                <input
                                    type="datetime-local"
                                    className="form-control"
                                    value={data.subscription_expires_at}
                                    onChange={(e) =>
                                        setData(
                                            "subscription_expires_at",
                                            e.target.value
                                        )
                                    }
                                />
                            </div>
                        </div>

                        <button
                            type="submit"
                            className="btn btn-primary"
                            disabled={processing}
                        >
                            {processing ? "Saving..." : "Create Gym"}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        </DashboardLayout>
    );
}