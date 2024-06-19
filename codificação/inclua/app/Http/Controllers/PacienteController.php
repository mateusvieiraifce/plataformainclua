<?php
namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
   
   function marcarconsultapasso1()
   {
      return view('userPaciente/marcarconsultapasso1');
   }
   
 
 
 
} ?>