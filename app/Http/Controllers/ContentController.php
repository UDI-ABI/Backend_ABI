<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 15;
        $search = $request->get('search');
        $rolesFilter = $request->get('roles');

        $query = Content::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($rolesFilter) {
            foreach ((array) $rolesFilter as $role) {
                $role = trim($role);
                if ($role !== '') {
                    $query->whereJsonContains('roles', $role);
                }
            }
        }

        $contents = $query->orderBy('name')->paginate($perPage);

        // 🔹 Corregido: se retorna la vista en lugar de JSON
        return view('contents.index', compact('contents'));
    }

    public function create()
    {
        return view('contents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'roles' => 'nullable|array',
        ]);

        $validated['roles'] = $validated['roles'] ?? [];

        Content::create($validated);

        return redirect()->route('contents.index')->with('success', 'Contenido creado exitosamente.');
    }

    public function show(Content $content)
    {
        return view('contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        return view('contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'roles' => 'nullable|array',
        ]);

        $validated['roles'] = $validated['roles'] ?? [];

        $content->update($validated);

        return redirect()->route('contents.index')->with('success', 'Contenido actualizado exitosamente.');
    }

    public function destroy(Content $content)
    {
        $content->delete();

        return redirect()->route('contents.index')->with('success', 'Contenido eliminado exitosamente.');
    }
}
