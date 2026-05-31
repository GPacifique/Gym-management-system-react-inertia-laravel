export default function Print({ receipt }) {
    return (
        <div className="p-10">
            <h1 className="text-2xl font-bold">
                Gym Receipt
            </h1>

            <p>Receipt #: {receipt.receipt_number}</p>
            <p>Member: {receipt.payment.member.first_name}</p>
            <p>Amount: {receipt.payment.amount}</p>
            <p>Date: {receipt.issued_at}</p>

            <button
                onClick={() => window.print()}
                className="mt-5 bg-black text-white px-4 py-2"
            >
                Print
            </button>
        </div>
    );
}