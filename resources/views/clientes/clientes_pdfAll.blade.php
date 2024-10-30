<!-- resources/views/clientes/clientes_pdfAll.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Lista de Clientes y Medidores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Lista de Clientes y Medidores</h2>  
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Dirección</th>
                <th>Número de Medidor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Número del cliente -->
                    <td>{{ $cliente->primer_nombre }} {{ $cliente->segundo_nombre }}</td>
                    <td>{{ $cliente->primer_apellido }} {{ $cliente->segundo_apellido }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>
                        @foreach($cliente->medidores as $medidor)
                            {{ $medidor->numero_medidor }}<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
