<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $produtos = Produto::with('categoria')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%') 
                          ->orWhere('description', 'like', '%' . $request->search . '%'); 
                });
            })
            ->when($request->has('price'), function ($query) use ($request) { 
                $query->where('price', $request->price); 
            })
            ->paginate(10);

        return response()->json($produtos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50', 
            'description' => 'nullable|string|max:200', 
            'price' => 'required|numeric|min:0', 
            'expiration_date' => 'required|date|after:today', 
            'categoria_id' => 'required|exists:categorias,id',
            'image' => 'required|url', 
        ]);

        $produto = Produto::create([
            'name' => $request->name, 
            'description' => $request->description, 
            'price' => $request->price, 
            'expiration_date' => $request->expiration_date, 
            'categoria_id' => $request->categoria_id,
            'image' => $request->image, 
        ]);

        return response()->json($produto, 201);
    }

    public function update(Request $request, Produto $produto)
    {
        $request->validate([
            'name' => 'nullable|string|max:50', 
            'description' => 'nullable|string|max:200', 
            'price' => 'nullable|numeric|min:0', 
            'expiration_date' => 'nullable|date|after:today', 
            'categoria_id' => 'nullable|exists:categorias,id',
            'image' => 'nullable|url', 
        ]);

        if ($request->has('image')) { 
            $produto->image = $request->image; 
        }

        $produto->update($request->except('image')); 

        return response()->json($produto);
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return response()->json(['message' => 'Produto excluído com sucesso']);
    }
}
