<!DOCTYPE html>
<html>
<head>
    <title>Label Harga</title>
    <style>

        @page { margin: 5mm; } 
        body { font-family: sans-serif; margin: 0; padding: 0; }
        
        .label-container {
            width: 100%;
        }

        .label-box {
            float: left;
            width: 20%; 
            height: 38mm;   
            box-sizing: border-box;
            padding: 5px;
            text-align: center;
            /*border: 1px dashed #ccc; */
        }

        .nama-barang { font-size: 11px; font-weight: bold; margin-bottom: 5px; }
        .harga { font-size: 14px; color: #000; font-weight: bold; }
        .id-barang { font-size: 9px; margin-top: 5px; color: #555; }
    </style>
</head>
<body>
    <div class="label-container">
        
        @for ($i = 0; $i < $skip_count; $i++)
            <div class="label-box"></div>
        @endfor

        @foreach ($data_cetak as $item)
            <div class="label-box">
                <div class="nama-barang">{{ $item->nama }}</div>
                <div class="harga">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>
                <div class="id-barang">ID: {{ $item->id_barang }}</div>
            </div>
        @endforeach

    </div>
</body>
</html>