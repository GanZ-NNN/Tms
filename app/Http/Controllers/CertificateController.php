<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificateController extends Controller
{
	// Minimal stub methods — extend as needed to match your routes.
	public function index()
	{
		return response()->json(['status' => 'ok']);
	}

	// ...add other methods referenced by your routes...
}
