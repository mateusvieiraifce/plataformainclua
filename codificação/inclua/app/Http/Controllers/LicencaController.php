<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;

class LicencaController extends Controller
{
    function getLicence()
    {
        $data = new DateTime('2025-06-04'); // Define uma data específica (ano-mês-dia)
        return $data->format('d/m/Y');
    }
}
