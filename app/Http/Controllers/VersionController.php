<?php

namespace App\Http\Controllers;

use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        $versions = Version::with('project')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('versions.index', compact('versions'));
    }

    public function create()
    {
        return view('versions.create');
    }

    public function store(Request $request)
    {
        Version::create($request->all());

        return redirect()->route('versions.index')
            ->with('success', 'Versión creada correctamente.');
    }

    public function show(Version $version)
    {
        $version->load(['project', 'contents' => function ($query) {
            $query->orderBy('name');
        }]);

        return view('versions.show', compact('version'));
    }

    public function edit(Version $version)
    {
        return view('versions.edit', compact('version'));
    }

    public function update(Request $request, Version $version)
    {
        $version->update($request->all());

        return redirect()->route('versions.index')
            ->with('success', 'Versión actualizada correctamente.');
    }

    public function destroy(Version $version)
    {
        if ($version->contentVersions()->exists()) {
            return back()->with('error', 'No es posible eliminar la versión porque tiene contenidos diligenciados.');
        }

        $version->delete();

        return redirect()->route('versions.index')
            ->with('success', 'Versión eliminada correctamente.');
    }
}
