<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = ['nombre', 'ruta', 'fecha'];
}
