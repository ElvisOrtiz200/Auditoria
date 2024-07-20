<?php

namespace App\Http\Controllers;

use App\Models\conexion;
use App\Models\excepcion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as pdfdow;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


class pdf extends Controller
{
    public function generatePDF()
    {
        $user = User::where('conectado', 1)->first();
$conexion = Conexion::where('estado', 1)->first();
$idConexion = $conexion->IdConexion;
$excepcion = Excepcion::select('tabla', 'columna', 'detalle')
                         ->where('IdConexion', $idConexion)
                         ->where('tipoExcepcion', 'Secuencialidad')
                         ->groupBy('tabla', 'columna', 'detalle')
                         ->get();

$pdf = pdfdow::loadView('reporte.secuencialidad', compact('excepcion', 'conexion', 'user'));

// Especifica el nombre del archivo que se descargará
$filename = 'boleta.pdf';

// Utiliza el método download() de la clase Response para generar una respuesta que descargue el archivo
return pdfdow::download($filename);
    }
    
}
