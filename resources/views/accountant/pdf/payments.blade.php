<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verified Payments Report</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #111827;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #064e3b;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #064e3b;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #6b7280;
            font-weight: bold;
        }
        .meta {
            margin-bottom: 20px;
            width: 100%;
        }
        .meta td {
            vertical-align: top;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #064e3b;
            color: white;
            text-align: left;
            padding: 10px;
            text-transform: uppercase;
            font-size: 10px;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .amount {
            text-align: right;
            font-family: monospace;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
        }
        .summary {
            float: right;
            width: 250px;
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        .summary-total {
            border-top: 1px solid #d1d5db;
            margin-top: 10px;
            padding-top: 10px;
            font-weight: bold;
            color: #064e3b;
            font-size: 14px;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-bold: true;
            background-color: #d1fae5;
            color: #065f46;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SHIIS '05 Reunion</h1>
        <p>Verified Payments Financial Report</p>
    </div>

    <table class="meta">
        <tr>
            <td>
                <strong>Report Generated:</strong> {{ date('F d, Y H:i') }}<br>
                <strong>Report Type:</strong> Verified Contributions
            </td>
            <td style="text-align: right;">
                <strong>Status:</strong> <span class="badge">AUDITED & VERIFIED</span>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Member Name</th>
                <th>Reference</th>
                <th style="text-align: right;">Amount (₦)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->updated_at->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $payment->user->name }}</strong><br>
                    <small style="color: #6b7280;">{{ $payment->user->email }}</small>
                </td>
                <td><small>{{ $payment->reference }}</small></td>
                <td class="amount">₦{{ number_format($payment->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div style="width: 100%;">
            <span style="float: left;">Total Verified Members:</span>
            <span style="float: right;">{{ $payments->count() }}</span>
            <div style="clear: both;"></div>
        </div>
        <div class="summary-total">
            <span style="float: left;">Grand Total:</span>
            <span style="float: right;">₦{{ number_format($totalAmount, 2) }}</span>
            <div style="clear: both;"></div>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        This is a computer-generated document. Verified by the SHIIS '05 Finance Committee.<br>
        &copy; {{ date('Y') }} SHIIS '05 Reunion Committee. All Rights Reserved.
    </div>
</body>
</html>
