<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat Kelulusan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            text-align: center;
            border: 10px solid #787878; 
            padding: 20px;
        }
        .container {
            border: 5px double #787878; 
            padding: 20px;
            height: 90%; 
        }
        h1 {
            color: #c9a648; 
            font-size: 50px;
            margin-bottom: 0;
            text-transform: uppercase;
        }
        h2 {
            font-weight: normal;
            font-size: 20px;
            margin-top: 10px;
        }
        .nama-peserta {
            font-size: 40px;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
            color: #333;
        }
        .deskripsi {
            font-size: 18px;
            line-height: 1.5;
            color: #555;
            margin-bottom: 40px;
        }
       
        table {
            width: 100%;
            margin-top: 50px;
        }
        td {
            text-align: center;
        }
        .garis-ttd {
            border-bottom: 1px solid black;
            width: 200px;
            margin: 0 auto;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SERTIFIKAT</h1>
        <h2>PENGHARGAAN INI DIBERIKAN KEPADA:</h2>

        <div class="nama-peserta">
            {{ strtoupper($nama) }}
        </div>

        <div class="deskripsi">
            Atas keberhasilannya menaklukkan error "SMTP Connection" dan "Migration Failed"<br>
            dalam pengerjaan Tugas Workshop Web Framework.<br>
            <i>Semoga ilmunya berkah dan errornya berkurang.</i>
        </div>

        <table>
            <tr>
                <td>
                    Diberikan Pada:<br>
                    <b>{{ $tanggal }}</b>
                </td>
                <td>
                    Mengetahui,<br>
                    Dosen Pengampu
                    <div class="garis-ttd"></div>
                    <b>( Akito Yamada )</b>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>