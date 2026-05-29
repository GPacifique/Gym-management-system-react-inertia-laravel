import React, { useEffect } from "react";
import { Html5QrcodeScanner } from "html5-qrcode";
import { router } from "@inertiajs/react";

export default function Scanner() {

    useEffect(() => {

        const scanner = new Html5QrcodeScanner(
            "reader",
            {
                fps: 5,
                qrbox: 250,
            }
        );

        scanner.render(success);

        function success(decodedText) {

            router.post("/attendance/check-in", {
                member_code: decodedText
            });

            scanner.clear();
        }

    }, []);

    return (
        <div className="p-6">

            <h1 className="text-3xl font-bold mb-6">
                Scan Member QR
            </h1>

            <div id="reader"></div>

        </div>
    );
}