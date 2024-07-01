<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html, body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            align-content: center;
        }

        .card {
            height: 13cm;
            background-color: white;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 10px;
            text-align: center;
            border: 10px solid #3b82f6;
            margin: 10px;
        }

        .qr {
            width: 180px;
            margin: 0 auto;
        }

        .qr img {
            width: 100%;
        }

        .info {
            margin-top: 25px;
        }

        .header {
            margin-top: 20px;
        }

        .header .title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .participant {
            margin: 40px 0;
            font-size: 1.125rem;
            color: #1d4ed8;
            font-weight: 600;
        }

        .participant-name {
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
        }

        .footer {
            margin-top: 20px;
            position: relative;
        }

        .footer p {
            margin: 5px 0;
            font-size: 0.875rem;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="qr">
        <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code">
    </div>
    <div class="header">
        <h1 class="title">{{$eventName}}</h1>
    </div>
    <div class="info">
        <div class="participant">
            Katılımcı
        </div>
        <div class="participant-name">
            {{ $name }}
        </div>
        <div class="footer">
            <p style="left: 0; position: absolute">#{{$applicationId}}</p>
            <p>{{$eventLocation}}, {{$eventStartDay}}-{{$eventEndDay}} {{$eventMonth}} {{$eventYear}}</p>
        </div>
    </div>
</div>
</body>
</html>
