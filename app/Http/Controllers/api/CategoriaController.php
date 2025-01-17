<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return response()->json($categorias);
    }
}
