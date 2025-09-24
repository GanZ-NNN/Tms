<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;

class HomeController extends Controller
{
    public function index()
    {
        $programs = Program::all();
        return view('home', compact('programs'));
    }
}
