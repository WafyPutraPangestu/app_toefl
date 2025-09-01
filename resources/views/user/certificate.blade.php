<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat TOEFL - {{ $user->name }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Times+New+Roman:wght@400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: 'Times New Roman', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .certificate-container {
            background: white;
            width: calc(100vw - 40px);
            height: calc(100vh - 40px);
            max-width: 1100px;
            max-height: 750px;
            margin: 0;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 6px solid #f8f9fa;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .certificate-border {
            border: 3px solid #007bff;
            padding: 15px;
            border-radius: 10px;
            position: relative;
            background: linear-gradient(45deg, #f8f9fa, #ffffff);
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .certificate-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .certificate-title {
            font-size: 32px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .certificate-subtitle {
            font-size: 16px;
            color: #34495e;
            letter-spacing: 2px;
        }

        .certificate-body {
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin: 10px 0;
        }

        .certificate-text {
            font-size: 16px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .recipient-name {
            font-size: 28px;
            font-weight: bold;
            color: #007bff;
            margin: 10px 0;
            text-decoration: underline;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .achievement-text {
            font-size: 14px;
            color: #34495e;
            margin: 10px 0;
            line-height: 1.4;
        }

        .score-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin: 15px 0;
            padding: 12px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            border-radius: 8px;
            border: 2px solid #007bff;
        }

        .score-item {
            text-align: center;
            flex: 1;
            min-width: 100px;
            margin: 5px;
        }

        .score-label {
            font-size: 12px;
            color: #6c757d;
            font-weight: bold;
            text-transform: uppercase;
        }

        .score-value {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .total-score {
            font-size: 24px !important;
            color: #28a745 !important;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .certificate-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 15px;
        }

        .signature-section {
            text-align: center;
        }

        .signature-line {
            width: 150px;
            height: 2px;
            background: #000;
            margin: 0 auto 8px;
        }

        .signature-text {
            font-size: 12px;
            color: #6c757d;
            line-height: 1.3;
        }

        .certificate-date {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
        }

        .certificate-number {
            font-size: 10px;
            color: #adb5bd;
            position: absolute;
            bottom: 5px;
            right: 15px;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            background: linear-gradient(45deg, #007bff, #0056b3);
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 5px;
            position: relative;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logo-placeholder::after {
            content: "TOEFL";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: bold;
            font-size: 10px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        .institution-name {
            font-size: 12px;
            color: #6c757d;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(0, 123, 255, 0.03);
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }

        .decorative-corner {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 3px solid #007bff;
        }

        .corner-tl {
            top: 10px;
            left: 10px;
            border-right: none;
            border-bottom: none;
        }

        .corner-tr {
            top: 10px;
            right: 10px;
            border-left: none;
            border-bottom: none;
        }

        .corner-bl {
            bottom: 10px;
            left: 10px;
            border-right: none;
            border-top: none;
        }

        .corner-br {
            bottom: 10px;
            right: 10px;
            border-left: none;
            border-top: none;
        }

        .achievement-badge {
            display: inline-block;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin: 5px 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Print optimizations */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="certificate-border">
            <!-- Decorative corners -->
            <div class="decorative-corner corner-tl"></div>
            <div class="decorative-corner corner-tr"></div>
            <div class="decorative-corner corner-bl"></div>
            <div class="decorative-corner corner-br"></div>

            <!-- Watermark -->
            <div class="watermark">TOEFL CERTIFICATE</div>

            <!-- Header Section -->
            <div>
                <!-- Logo and Institution -->
                <div class="logo-section">
                    <div class="logo-placeholder"></div>
                    <div class="institution-name">LEMBAGA SERTIFIKASI TOEFL INDONESIA</div>
                </div>

                <!-- Certificate Header -->
                <div class="certificate-header">
                    <div class="certificate-title">SERTIFIKAT</div>
                    <div class="certificate-subtitle">TEST OF ENGLISH AS A FOREIGN LANGUAGE</div>
                </div>
            </div>

            <!-- Certificate Body -->
            <div class="certificate-body">
                <div class="certificate-text">Dengan ini menyatakan bahwa</div>

                <div class="recipient-name">{{ strtoupper($user->name) }}</div>

                <div class="achievement-text">
                    telah berhasil menyelesaikan ujian <strong>{{ $testPackage->name }}</strong>
                </div>

                <div class="achievement-badge">{{ $result->status }}</div>

                <!-- Score Section -->
                <div class="score-section">
                    <div class="score-item">
                        <div class="score-label">Listening</div>
                        <div class="score-value">{{ $result->score_listening }}</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Structure</div>
                        <div class="score-value">{{ $result->score_structure }}</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Reading</div>
                        <div class="score-value">{{ $result->score_reading }}</div>
                    </div>
                    <div class="score-item">
                        <div class="score-label">Total Score</div>
                        <div class="score-value total-score">{{ $result->total_score }}</div>
                    </div>
                </div>

                <div class="achievement-text">
                    Sertifikat ini diberikan sebagai pengakuan atas pencapaian yang telah diraih<br>
                    dalam menguasai kemampuan bahasa Inggris sesuai standar internasional.
                </div>
            </div>

            <!-- Footer Section -->
            <div class="certificate-footer">
                <div class="certificate-date">
                    Tangerang, {{ \Carbon\Carbon::parse($result->created_at)->isoFormat('D MMMM Y') }}
                </div>

                <div class="signature-section">
                    <div class="signature-line"></div>
                    <div class="signature-text">
                        <strong>Direktur Lembaga</strong><br>
                        Dr. Ahmad Suharto, M.Ed
                    </div>
                </div>
            </div>

            <!-- Certificate Number -->
            <div class="certificate-number">
                No. Sertifikat: TOEFL/{{ date('Y') }}/{{ str_pad($result->id, 6, '0', STR_PAD_LEFT) }}
            </div>
        </div>
    </div>
</body>

</html>
