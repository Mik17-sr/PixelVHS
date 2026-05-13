<?php

namespace App\Http\Controllers;

use App\Models\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DirectorController
{
    
    public function registrarDirector(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'biografia' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);
        $director = new Director();
        $director->nombre = $request->input('nombre');
        $director->biografia = $request->input('biografia');

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('directores', 'public');
            $director->foto = $path;
        }
        $director->save();
        return response()->json([
            'message'  => 'Director registrado exitosamente',
            'director' => $director,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'biografia' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $director = Director::findOrFail($id);
        $director->nombre = $request->input('nombre');
        $director->biografia = $request->input('biografia');

        if ($request->hasFile('foto')) {
            if ($director->foto) {
                Storage::delete($director->foto);
            }
            $path = $request->file('foto')->store('directores', 'public');
            $director->foto = $path;
        }
        $director->save();
        return response()->json([
            'message'  => 'Director actualizado exitosamente',
            'director' => $director->fresh(), 
        ]);
    }

    public function destroy($id)
    {
        $director = Director::findOrFail($id);
        if ($director->foto) {
            Storage::disk('public')->delete($director->foto);
        }
        $director->delete();
        return response()->json(['message' => 'Director eliminado exitosamente']);
    }
}
