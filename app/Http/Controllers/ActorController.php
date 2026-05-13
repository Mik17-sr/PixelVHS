<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class ActorController extends Controller
{
    public function registrar(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'biografia' => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        $actor = new Actor();
        $actor->nombre    = $request->input('nombre');
        $actor->biografia = $request->input('biografia');

        if ($request->hasFile('foto')) {
            $actor->foto = $request->file('foto')->store('actores', 'public');
        }

        $actor->save();

        return response()->json([
            'message' => 'Actor registrado exitosamente',
            'actor'   => $actor,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'biografia' => 'nullable|string',
            'foto'      => 'nullable|image|max:2048',
        ]);

        $actor = Actor::findOrFail($id);
        $actor->nombre    = $request->input('nombre');
        $actor->biografia = $request->input('biografia');

        if ($request->hasFile('foto')) {
            if ($actor->foto) {
                Storage::disk('public')->delete($actor->foto);
            }
            $actor->foto = $request->file('foto')->store('actores', 'public');
        }

        $actor->save();

        return response()->json([
            'message' => 'Actor actualizado exitosamente',
            'actor'   => $actor->fresh(),
        ]);
    }

    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);

        if ($actor->foto) {
            Storage::disk('public')->delete($actor->foto);
        }

        $actor->delete();

        return response()->json([
            'message' => 'Actor eliminado exitosamente',
        ]);
    }
}