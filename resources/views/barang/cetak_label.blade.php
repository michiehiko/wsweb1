<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Label TnJ 108</title>
    <style>
        @page {
            /* Margin tepi kertas disetel sangat tipis karena ukuran custom sudah ngepas */
            margin-top: 3mm; 
            margin-left: 5mm; 
            margin-right: 5mm;
            margin-bottom: 0mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 8px; /* Font diturunkan sedikit biar tidak meluber */
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
            table-layout: fixed; 
            width: 100%;
        }
        td {
            width: 38mm; /* Lebar absolut label 108 */
            height: 18mm; /* Tinggi absolut label 108 */
            text-align: center;
            vertical-align: middle;
            overflow: hidden;
            padding: 0.5mm; 
            
            /* TIPS: Buka comment garis putus-putus di bawah ini buat ngetes letak di HVS biasa */
            border: 1px dotted #ccc; 
        }
    </style>
</head>
<body>
    <table>
        <tr>
        @php $counter = 0; @endphp

        @foreach($items as $item)
            @if($counter > 0 && $counter % 5 == 0)
                </tr><tr>
            @endif

            <td>
                @if($item !== null)
                    <strong>{{ $item->nama }}</strong><br>
                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                @endif
            </td>

            @php $counter++; @endphp
        @endforeach

        @while($counter % 5 != 0)
            <td></td>
            @php $counter++; @endphp
        @endwhile
        </tr>
    </table>
</body>
</html>