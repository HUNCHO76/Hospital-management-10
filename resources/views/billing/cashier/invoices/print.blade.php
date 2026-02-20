<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #111827; }
        .header { display: flex; justify-content: space-between; margin-bottom: 16px; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 8px; font-size: 12px; text-align: left; }
        .totals { margin-top: 12px; width: 280px; margin-left: auto; }
        .totals div { display: flex; justify-content: space-between; margin: 4px 0; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <button class="no-print" onclick="window.print()">Print</button>

    <div class="header">
        <div>
            <h2>Hospital Invoice</h2>
            <p class="muted">Invoice #: {{ $invoice->invoice_number }}</p>
            <p class="muted">Date: {{ $invoice->invoice_date?->format('M d, Y H:i') }}</p>
        </div>
        <div>
            <p><strong>Patient:</strong> {{ $invoice->patient->full_name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->item_type }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total_price, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div><span>Subtotal</span><span>{{ number_format($invoice->subtotal, 2) }}</span></div>
        <div><span>Discount</span><span>{{ number_format($invoice->discount_amount, 2) }}</span></div>
        <div><span>Tax</span><span>{{ number_format($invoice->tax_amount, 2) }}</span></div>
        <div><strong>Total</strong><strong>{{ number_format($invoice->total_amount, 2) }}</strong></div>
        <div><span>Paid</span><span>{{ number_format($invoice->paid_amount, 2) }}</span></div>
        <div><strong>Balance</strong><strong>{{ number_format($invoice->balance, 2) }}</strong></div>
    </div>
</body>
</html>
