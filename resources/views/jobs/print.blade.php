<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $job->job_number }} | Arslan's Workshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=IBM+Plex+Mono:wght@400;500;600&family=IBM+Plex+Sans:wght@400;500;600;700&family=Noto+Nastaliq+Urdu:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'IBM Plex Sans', sans-serif;
            background: #f3f3f3;
            color: #000000;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        .screen-only {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: opacity 0.2s;
        }

        .btn:hover { opacity: 0.85; }

        .btn-print {
            background: #111111;
            color: #ffffff;
        }

        .btn-back {
            background: #ffffff;
            color: #111;
            border: 1.5px solid #d1d1d1;
        }

        /* ── 80mm Thermal Receipt ── */
        .receipt {
            width: 80mm;
            max-width: 100%;
            margin: 0 auto;
            background: #ffffff;
            border: 1px dashed #cccccc;
            padding: 5mm;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            font-size: 11px;
            line-height: 1.4;
            color: #000000;
        }

        /* Centered Header */
        .receipt-header {
            text-align: center;
            margin-bottom: 4mm;
        }

        .shop-name {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #000000;
            line-height: 1.1;
        }

        .shop-tagline {
            font-family: 'Noto Nastaliq Urdu', serif;
            font-size: 0.95rem;
            margin-top: 0.25rem;
            color: #333333;
        }

        /* Metadata */
        .receipt-meta {
            margin: 3mm 0;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 10px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .receipt-meta .job-number {
            font-weight: 700;
            font-size: 11px;
        }

        /* Center Payment Status Text */
        .payment-status-text {
            text-align: center;
            font-size: 11px;
            font-weight: 700;
            padding: 1.5mm 0;
            margin: 2mm 0;
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            text-transform: uppercase;
        }

        .status-paid { color: #000000; }
        .status-partial { color: #000000; }
        .status-unpaid { color: #000000; }

        /* Dashed separator */
        .divider {
            border-top: 1px dashed #000000;
            margin: 3mm 0;
        }

        /* Info Section (Customer & Vehicle) */
        .info-section {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin-bottom: 3mm;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
        }

        .info-label {
            color: #555555;
            font-weight: 500;
        }

        .info-val {
            font-weight: 600;
            text-align: right;
        }

        /* Merged Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 3mm 0;
        }

        .items-table th {
            border-bottom: 1px dashed #000000;
            padding: 1.5mm 0;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            text-align: left;
        }

        .items-table th.right {
            text-align: right;
        }

        .items-table td {
            padding: 2mm 0;
            vertical-align: top;
        }

        .items-table td.right {
            text-align: right;
            font-family: 'IBM Plex Mono', monospace;
            font-weight: 600;
        }

        .item-name {
            font-weight: 600;
            font-size: 11px;
        }

        .item-subdetails {
            font-size: 9px;
            color: #555555;
            margin-top: 1px;
            font-family: 'IBM Plex Mono', monospace;
        }

        /* Totals Block */
        .totals-block {
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-top: 2mm;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            font-size: 10px;
        }

        .total-line.grand {
            font-size: 12px;
            font-weight: 700;
            border-top: 1px dashed #000000;
            border-bottom: 1px dashed #000000;
            padding: 2mm 0;
            margin: 1.5mm 0;
        }

        .total-line.balance-due {
            font-size: 11px;
            font-weight: 700;
        }

        /* Next Service Box */
        .next-service-box {
            border: 1px dashed #000000;
            padding: 2.5mm;
            margin: 4mm 0 2mm 0;
            text-align: center;
        }

        .next-service-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1mm;
        }

        .next-service-info {
            font-size: 11px;
            font-weight: 600;
        }

        /* Receipt Footer */
        .receipt-footer {
            text-align: center;
            margin-top: 5mm;
        }

        .notes-section {
            text-align: left;
            margin-bottom: 3mm;
            padding: 2mm;
            border: 1px dotted #999999;
            background: #fafafa;
        }

        .notes-title {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.5mm;
        }

        .notes-content {
            font-size: 10px;
            color: #333333;
        }

        .thank-you {
            font-size: 10px;
            color: #333333;
            margin-top: 3mm;
        }

        .urdu-thanks {
            font-family: 'Noto Nastaliq Urdu', serif;
            font-size: 11px;
            margin-top: 1.5mm;
            color: #000000;
        }

        /* ── Print Styles ── */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
                margin: 0;
                width: 80mm;
            }

            .screen-only { display: none !important; }

            .receipt {
                width: 80mm;
                max-width: 100%;
                box-shadow: none;
                border: none;
                border-radius: 0;
                padding: 3mm;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    @php
        $laborTotal = $job->services->sum('labor_cost');
        $partsTotal = $job->parts->sum(fn($p) => $p->quantity * $p->unit_price);
        $grandTotal = $laborTotal + $partsTotal;
        $balanceDue = max(0, $grandTotal - $job->amount_paid);
    @endphp

    {{-- Screen-only action bar --}}
    <div class="screen-only">
        <button class="btn btn-print" onclick="window.print()">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Print Slip
        </button>
        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-back">
            ← Back to Job Card
        </a>
    </div>

    {{-- Receipt --}}
    <div class="receipt">

        {{-- Header --}}
        <div class="receipt-header">
            <div class="shop-name">Arslan's Workshop</div>
            <div class="shop-tagline">ارسلان ورکشاپ</div>
        </div>

        {{-- Metadata --}}
        <div class="receipt-meta">
            <div class="info-row">
                <span class="info-label">Slip #</span>
                <span class="info-val" style="font-family:'IBM Plex Mono',monospace;">{{ $job->job_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date:</span>
                <span class="info-val">{{ $job->date_in->format('d M Y') }}</span>
            </div>
            @if($job->date_out)
                <div class="info-row">
                    <span class="info-label">Closed:</span>
                    <span class="info-val">{{ $job->date_out->format('d M Y') }}</span>
                </div>
            @endif
        </div>

        {{-- Payment Status Center Bar --}}
        <div class="payment-status-text
            @if($job->payment_status === 'paid') status-paid
            @elseif($job->payment_status === 'partial') status-partial
            @else status-unpaid @endif">
            @if($job->payment_status === 'paid')
                *** PAID — ادا شدہ ***
            @elseif($job->payment_status === 'partial')
                *** PARTIAL — جزوی ادائیگی ***
            @else
                *** UNPAID — واجب الادا ***
            @endif
        </div>

        {{-- Info Section (Customer & Vehicle) --}}
        <div class="info-section">
            @if($job->customer)
                <div class="info-row">
                    <span class="info-label">Customer:</span>
                    <span class="info-val">{{ $job->customer->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span class="info-val">{{ $job->customer->phone }}</span>
                </div>
            @endif
            @if($job->car)
                <div class="info-row">
                    <span class="info-label">Vehicle:</span>
                    <span class="info-val">{{ $job->car->make }} {{ $job->car->model }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Plate #:</span>
                    <span class="info-val">{{ $job->car->plate_number }}</span>
                </div>
            @endif
        </div>

        {{-- Combined Services & Parts Table --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item / تفصیل</th>
                    <th class="right">Amount / رقم</th>
                </tr>
            </thead>
            <tbody>
                {{-- Render Services --}}
                @foreach($job->services as $service)
                    <tr>
                        <td>
                            <div class="item-name">
                                @if($service->servicePreset)
                                    {{ $service->servicePreset->name }}
                                @else
                                    {{ $service->description ?? 'Custom Service' }}
                                @endif
                            </div>
                            <div class="item-subdetails">[Service / سروس]</div>
                        </td>
                        <td class="right">Rs. {{ number_format($service->labor_cost) }}</td>
                    </tr>
                @endforeach

                {{-- Render Parts --}}
                @foreach($job->parts as $part)
                    @php $lineTotal = $part->quantity * $part->unit_price; @endphp
                    <tr>
                        <td>
                            <div class="item-name">
                                @if($part->partsReference)
                                    {{ $part->partsReference->name }}
                                @else
                                    {{ $part->part_name ?? 'Custom Part' }}
                                @endif
                            </div>
                            <div class="item-subdetails">
                                Qty: {{ number_format($part->quantity) }} x Rs. {{ number_format($part->unit_price) }}
                            </div>
                        </td>
                        <td class="right">Rs. {{ number_format($lineTotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Divider --}}
        <div class="divider"></div>

        {{-- Totals Block --}}
        <div class="totals-block">
            <div class="total-line">
                <span class="info-label">Labor Subtotal / اجرت:</span>
                <span class="info-val">Rs. {{ number_format($laborTotal) }}</span>
            </div>
            <div class="total-line">
                <span class="info-label">Parts Subtotal / پرزہ جات:</span>
                <span class="info-val">Rs. {{ number_format($partsTotal) }}</span>
            </div>
            <div class="total-line grand">
                <span class="info-label">GRAND TOTAL / کل رقم:</span>
                <span class="info-val">Rs. {{ number_format($grandTotal) }}</span>
            </div>
            <div class="total-line">
                <span class="info-label">Amount Paid / ادا شدہ:</span>
                <span class="info-val">Rs. {{ number_format($job->amount_paid) }}</span>
            </div>
            <div class="total-line balance-due">
                <span class="info-label">Balance Due / باقی رقم:</span>
                <span class="info-val">Rs. {{ number_format($balanceDue) }}</span>
            </div>
        </div>

        {{-- Next Service Reminder --}}
        @if($job->next_service_date || $job->next_service_mileage)
            <div class="next-service-box">
                <div class="next-service-title">⏰ Next Service Reminder / اگلی سروس یاد دہانی</div>
                <div class="next-service-info">
                    @if($job->next_service_date)
                        {{ \Carbon\Carbon::parse($job->next_service_date)->format('d M Y') }}
                    @endif
                    @if($job->next_service_mileage)
                        @if($job->next_service_date) &nbsp;•&nbsp; @endif
                        {{ number_format($job->next_service_mileage) }} km
                    @endif
                </div>
            </div>
        @endif

        {{-- Notes Section --}}
        @if($job->notes)
            <div class="divider"></div>
            <div class="notes-section">
                <div class="notes-title">Notes / نوٹس:</div>
                <div class="notes-content">{{ $job->notes }}</div>
            </div>
        @endif

        {{-- Warranty Notes Section --}}
        @if($job->warranty_notes)
            <div class="notes-section" style="margin-top: 1mm;">
                <div class="notes-title">Warranty / وارنٹی:</div>
                <div class="notes-content">{{ $job->warranty_notes }}</div>
            </div>
        @endif

        {{-- Footer --}}
        <div class="receipt-footer">
            <div class="divider" style="margin: 2mm 0;"></div>
            <div class="thank-you">Thank you for trusting Arslan's Workshop.</div>
            <div class="urdu-thanks">ارسلان ورکشاپ پر اعتماد کرنے کا شکریہ</div>
        </div>

    </div>
</body>
</html>
