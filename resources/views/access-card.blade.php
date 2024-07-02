<!DOCTYPE html>
<html lang="tr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            align-content: center;
        }

        body {
            background-image: url("assets/access-card-background.jpg");
            background-repeat: no-repeat;
            background-size: contain;
        }

        .card {
            height: 13cm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .qr {
            margin-top: 485px;
            border-radius: 20px;

        }

        .participant {
            margin-top: 120px;
            font-size: 85px;
            font-weight: bold;
            color: white;
        }

        .applicationId {
            margin-top: 50px;
            font-size: 50px;
            font-weight: bold;
            color: white;
        }

        .info {
            margin-top: 20px;
            font-size: 40px;
            font-weight: bold;
            color: white;
        }

        .advertising {
            margin-top: 30px;
            font-size: 40px;
            color: white;
        }
    </style>
</head>
<body>
<div class="card">
    <img src="data:image/png;base64,{{ $qrcode }}" class="qr" alt="QR Code">
    <h1 class="participant">
        {{$name}}
    </h1>
    <h1 class="applicationId">
        #SDN-{{$applicationId}}
    </h1>
    <p class="info">
        Varış / Ayrılış : {{$eventStartDate}} - {{$eventEndDate}}
    </p>
    <p class="advertising">
        www.codenteq.com
    </p>
</div>
</body>
</html>
