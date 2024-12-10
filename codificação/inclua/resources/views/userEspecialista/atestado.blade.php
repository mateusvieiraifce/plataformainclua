<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atestado</title>
    <style>
        body {
        font-family: Arial, Helvetica, sans-serif; 
        font-size: 1rem;
        }
        main {
            text-align: center;
            margin-top: 250px;
        }

        header {
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ $logo }}" alt="logo da empresa">
    </header>

    <main>
        <h1>Atestado Médico</h1>  
        @foreach($atestado as $item)
            <p style="text-align: justify;">{{ $item->texto }}</p>
            @php
                $data = date('d/m/Y', strtotime($item->data));
            @endphp
            <p>Assinatura:_______________________</p>
            <p>Data:{{ $data }}</p>
        @endforeach
    </main>
</body>
</html>
