<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bukti Pembelian</title>
    <style>
      /* Wrapper styling */
#back-wrap {
    margin: 30px auto;
    width: 500px;
    display: flex;
    justify-content: flex-end;
}

/* Back button styling */
.btn-back {
    padding: 8px 15px;
    color: #fff;
    background: #4CAF50; /* Warna hijau lebih lembut */
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-back:hover {
    background: #45a049;
}

/* Receipt styling */
#receipt {
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    padding: 20px;
    margin: 30px auto;
    width: 500px;
    background: #FFF;
    border-radius: 10px;
    font-family: Arial, sans-serif;
}

/* Header and info text */
h2 {
    font-size: 1.2rem;
    color: #333;
    margin: 0;
}

p {
    font-size: 0.9rem;
    color: #555;
    line-height: 1.4;
}

/* Information section */
#top .info {
    text-align: center;
    margin: 10px 0 20px;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

td, th {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
    font-size: 0.9rem;
    color: #333;
}

.tabletitle {
    background-color: #f2f2f2;
    font-weight: bold;
}

/* Items and totals */
.service {
    border-bottom: 1px solid #ddd;
}

.itemtext {
    color: #555;
}

#legalcopy {
    margin-top: 20px;
    text-align: center;
    font-size: 0.9rem;
    color: #888;
}

.legal strong {
    color: #333;
}

/* Print button */
.btn-print {
    display: inline-block;
    float: right;
    color: #333;
    background: #e0e0e0;
    padding: 8px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.btn-print:hover {
    background: #ccc;
    color: #333;
}

    </style>
</head


        <body>
            <div id="back-wrap">
                <a href="{{ route('kasir.order') }}" class="btn-back">Kembali</a>
            </div>
            <div id="receipt">
                <a href="{{ route('kasir.download.pdf', $order['id'])}}" class="btn-print">Cetak (.pdf)</a>
                 <center id="top">
             <div class="info">
                    <h2>Apotek Mimoyyy</h2>
                </div>
                </center>
                    <div id="mid">
                <div class="info">
              <p>
             Alamat: Jalan Menuju Kebahagiaan<br>
             Email: apotekmimoyyy@gmail.com<br>
             Phone: 0818-0411-3951<br>
            </p>
                </div>
            </div>
            <div id="bot">
                <div id="table">
                    <table>
                        <tr class="tabletitle">
                            <td class="item">
                                <h2>Obat</h2>
                            </td>
                            <td class="item">
                                <h2>Total</h2>
                            </td>
                            <td class="Rate">
                                <h2>Harga</h2>
                            </td>
                        </tr>
                        @foreach ($order['medicines'] as $medicine)
                        <tr class="service">
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine ['name_medicine'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">{{ $medicine ['qty'] }}</p>
                            </td>
                            <td class="tableitem">
                                <p class="itemtext">Rp. {{ number_format ($medicine['price'],0,',','.') }}</p>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="tabletitle">
                            <td></td>
                            <td class="Rate">
                                <h2>PPN (10%)</h2>
                            </td>
                            @php
                            $ppn = $order['total_price'] *0.01;
                            @endphp

                            <td class="payment"> 
                                <h2>Rp. {{ number_format ($ppn,0,',','.') }}</h2>
                            </td>
                        </tr>
                        <tr>
                            <tr class="tabletitle">
                                <td></td>
                                <td class="Rate">
                                    <h2>Total Harga</h2>
                                </td>
                                <td class="payment">
                                    <h2>Rp. {{ number_format ($order['total_price'],0,',','.') }}</h2>
                                </td>
                            </tr>
                        </tr>
                    </table>
                </div>
                <div id="legalcopy">
                    <p class="legal"><strong>Terimakasih atas pembelian anda!</strong>

                    </p>

                </div>
            </div>
        </body>
        </html>
