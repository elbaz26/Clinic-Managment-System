<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Medical Appointment Token #{{ $appointment->id }}</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .container { padding: 40px; }
        .ticket {
            border: 1px solid #e2e8f0;
            border-top: 8px solid #1e3a8a;
            border-radius: 15px;
            padding: 30px;
            background: #ffffff;
            position: relative;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #1e3a8a;
            font-size: 26px;
            margin: 0;
            letter-spacing: 1px;
        }
        .header p {
            font-size: 13px;
            color: #64748b;
            margin: 5px 0 0 0;
            text-transform: uppercase;
        }
        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #1e3a8a;
            text-transform: uppercase;
            margin-bottom: 15px;
            background: #f8fafc;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .info-grid { width: 100%; margin-bottom: 25px; }
        .info-item { padding: 10px 0; border-bottom: 1px solid #f8fafc; }
        .label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            display: block;
        }
        .value {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .status-badge {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px dashed #e2e8f0;
            padding-top: 20px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(226, 232, 240, 0.4);
            z-index: -1;
            font-weight: 900;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="ticket">
        <div class="watermark">CLINIC</div>
        
        <div class="header">
            <h1>CLINIC MANAGEMENT SYSTEM</h1>
            <p>Official Patient Appointment Voucher</p>
        </div>

        <div class="section-title">Patient & Visit Details</div>
        
        <table class="info-grid">
            <tr>
                <td class="info-item" style="width: 50%;">
                    <span class="label">Reference Number</span>
                    <span class="value">#APP-000{{ $appointment->id }}</span>
                </td>
                <td class="info-item">
                    <span class="label">Booking Status</span>
                    <span class="status-badge">{{ strtoupper($appointment->status) }}</span>
                </td>
            </tr>
            <tr>
                <td class="info-item">
                    <span class="label">Patient Name</span>
                    <span class="value">{{ $appointment->patient?->user?->name ?? 'Guest Patient' }}</span>
                </td>
                <td class="info-item">
                    <span class="label">Consulting Doctor</span>
                    <span class="value">Dr. {{ $appointment->doctor?->user?->name ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td class="info-item">
                    <span class="label">Appointment Date</span>
                    <span class="value">{{ $appointment->appointment_date }}</span>
                </td>
                <td class="info-item">
                    <span class="label">Scheduled Time</span>
                    <span class="value">{{ $appointment->appointment_time }}</span>
                </td>
            </tr>
        </table>

        <div class="section-title">Doctor's Notes / Symptoms</div>
        <div style="min-height: 60px; font-size: 14px; color: #475569;">
            {{ $appointment->notes ?? 'No specific notes provided for this visit.' }}
        </div>

        <div class="footer">
            * Please present this digital or printed voucher at the reception desk.<br>
            * Kindly arrive 15 minutes before your scheduled time.<br><br>
            <strong>System Generated Document - No Signature Required</strong>
        </div>
    </div>
</div>

</body>
</html>

