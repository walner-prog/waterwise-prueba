<?php
namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Cliente([
            'primer_nombre' => $row['primer_nombre'], // Cambia estos nombres según la cabecera de tu Excel
            'segundo_nombre' => $row['segundo_nombre'] ?? null, // Permitir null
            'primer_apellido' => $row['primer_apellido'],
            'segundo_apellido' => $row['segundo_apellido'] ?? null, // Permitir null
            'direccion' => $row['direccion'] ?? null, // Permitir null
            'telefono' => $row['telefono'] ?? null, // Permitir null
            'email' => $row['email'] ?? null, // Permitir null
            'fecha_registro' => \Carbon\Carbon::now(), // O puedes usar la fecha de registro si está en el Excel
        ]);
    }
}
