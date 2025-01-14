<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoController extends Controller
{
    public function index(Request $request)
    {
        $query = Produto::with('categoria');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('description', 'LIKE', "%$search%");
            });
        }

        return response()->json($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0',
            'expiration_date' => 'required|date|after_or_equal:today',
            'image' => 'required|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $validated['image'] = $request->file('image')->store('produtos', 'public');
        $produto = Produto::create($validated);

        return response()->json($produto, 201); 
    }

    public function show($id)
    {
        $produto = Produto::with('categoria')->findOrFail($id);

        return response()->json($produto);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|max:50',
            'description' => 'sometimes|max:200',
            'price' => 'sometimes|numeric|min:0',
            'expiration_date' => 'sometimes|date|after_or_equal:today',
            'image' => 'sometimes|image|max:2048',
            'categoria_id' => 'sometimes|exists:categorias,id',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($produto->image);
            $validated['image'] = $request->file('image')->store('produtos', 'public'); 
        }

        $produto->update($validated);

        return response()->json($produto);
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);

        Storage::disk('public')->delete($produto->image);
        $produto->delete();

        return response()->json(['message' => 'Produto deletado com sucesso.']); 
    }
}
