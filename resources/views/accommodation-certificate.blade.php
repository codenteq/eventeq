<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konaklama Belgesi</title>
    <style>
        html {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            align-content: center;
        }
        .container {
            margin: auto;
            max-width: 64rem;
            padding: 5px;
        }


        .header {
            text-align: center;
            margin-bottom: 16px;
        }

        .header h1 {
            font-size: 1.125rem;
            font-weight: bold;
        }

        .header h2 {
            font-size: 1rem;
        }

        h3 {
            text-transform: uppercase;
        }

        .sub-header {
            margin-bottom: 8px;
            width: 100%;
            border: none;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #9CA3AF;
            margin-bottom: 16px;
        }

        .table th, .table td {
            border: 1px solid #9CA3AF;
            padding: 8px;
            font-size: 0.75rem;
            vertical-align: top;
        }

        .table .col-span-2 {
            colspan: 2;
        }

        .table .col-span-3 {
            colspan: 3;
        }

        .table-header {
            text-align: center;
            margin-bottom: 16px;
        }

        .table-header h4 {
            font-size: 1rem;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .flex-col {
            display: flex;
            flex-direction: column;
            font-size: 0.75rem;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .gap-5 {
            gap: 20px;
        }
    </style>
</head>

<body>
@foreach($applications as $application)
<div class="container">
    <div class="header">
        <h1>TOPUKLU YAYLASI KAMPİNG</h1>
        <h2>KONAKLAMA BELGESİ</h2>
    </div>
    <table class="sub-header">
        <tr>
            <td>LÜTFEN BÜYÜK HARFLERLE YAZINIZ. <br /> PLEASE USE CAPITAL LETTERS.</td>
            <td style="font-size: 1rem; font-weight: bold">Başvuru ID: {{$application['id']}}</td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <td>
                T.C. KİMLİK NO:
            </td>
            <td colspan="3"></td>
        </tr>
        <tr >
            <td colspan="2">
                <div>Adı Soyadı / Name Surname</div>
                <h3>{{$application['user']['name']}}</h3>
            </td>
            <td>Doğum yeri / Place of birth</td>
            <td>
                <div>Doğum tarihi / Date of birth</div>
                <h3>.../.../{{\Carbon\Carbon::parse($application['user']['birth_date'])->format('Y')}}</h3>
            </td>
        </tr>
        <tr >
            <td>Baba Adı / Father Name</td>
            <td>Uyruğu / Nationality</td>
            <td>
                <div>Mesleği / Profession</div>
                <h3>Mühendis</h3>
            </td>
            <td>
                <div>Geldiği Yer / Arriving From</div>
                <h3>{{$application['city']['name']}}</h3>
            </td>
        </tr>
        <tr >
            <td>Kimlik Belgesi / Travel Document</td>
            <td>Tarih ve Sayısı / Date and Number</td>
            <td>Verildiği Yer / Place of Issue</td>
            <td>
                <div>E-Posta</div>
                <h3>{{$application['user']['email']}}</h3>
            </td>
        </tr>
        <tr>
            <td colspan="2">Adres / Address</td>
            <td colspan="2">
                <div>Cep Telefonu / Gsm Phone</div>
                <h3>{{$application['user']['phone']}}</h3>
            </td>
        </tr>
    </table>
    <div class="table-header">
        <h4>Beraberindekiler / Shared with</h4>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Adı Soyadı / Name, Surname</th>
            <th>Yakınlığı / Relationship</th>
            <th>Yaşı / Age</th>
            <th>İmza / Signature</th>
        </tr>
        </thead>
        <tbody>
        @php
            $counter = 1;
        @endphp

        @foreach($application['children'] as $child)
            @php
                $age = \Carbon\Carbon::parse($child['birth_date'])->age;
            @endphp
            <tr>
                <td>{{$counter}}. {{ $child['full_name'] }}</td>
                <td></td>
                <td>{{ $age }}</td>
                <td></td>
            </tr>

            @php
                $counter++;
            @endphp
        @endforeach

        @for($i = $counter; $i <= 5; $i++)
            <tr>
                <td>{{$i}}</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endfor
        </tbody>
    </table>
    <table class="table">
        <tr style="height: 64px;">
            <td>
                <div>Konaklama Şekli / Type of Accommodation</div>
                <h3></h3>
            </td>
            <td>
                <div>Giriş Tarihi / Departure Date</div>
                <h3>{{\Carbon\Carbon::parse($application['arrival_date'])->format('d/m/Y')}}</h3>
            </td>
            <td>
                <div>Çıkış Tarihi / Departure Date</div>
                <h3>{{\Carbon\Carbon::parse($application['departure_date'])->format('d/m/Y')}}</h3>
            </td>
            <td>Fiyat / Price</td>
            <td>Kişi / Person</td>
            <td>Gün / Day</td>
        </tr>
    </table>
    <div class="flex">
        <div class="flex-col">
            <span>Fatura Adresi / Invoice Address:</span> <br>
            <span class="mt-4">Adres:</span><br>
            <span>V.D. No:</span><br>
        </div>
        <div class="flex-col gap-5">
            <span>KAYIT</span>
            <span>OTO PLAKA / CAR PLATE:</span>
        </div>
    </div>
</div>
@endforeach
</body>

</html>


