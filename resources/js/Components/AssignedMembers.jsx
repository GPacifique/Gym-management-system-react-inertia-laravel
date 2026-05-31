import React from "react";

export default function AssignedMembers({ assignedMembers = [] }) {
    return (
        <div className="bg-white p-4 rounded-lg shadow">
            <h2 className="text-lg font-bold mb-4">
                Assigned Members ({assignedMembers.length})
            </h2>

            {assignedMembers.length === 0 ? (
                <p>No members assigned.</p>
            ) : (
                <div className="space-y-3">
                    {assignedMembers.map((member) => (
                        <div
                            key={member.id}
                            className="border p-3 rounded"
                        >
                            <p className="font-semibold">
                                {member.name}
                            </p>

                            <p className="text-sm text-gray-500">
                                {member.email}
                            </p>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}