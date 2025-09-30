<?php

namespace App\Http\Controllers;

use App\Models\ContentVersion;
use Illuminate\Http\Request;

class ContentVersionController extends Controller
{
    public function index()
    {
        $contentVersions = ContentVersion::with(['content', 'version.project'])
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('content-versions.index', compact('contentVersions'));
    }

    public function create()
    {
        return view('content-versions.create');
    }

    public function store(Request $request)
    {
        ContentVersion::create($request->all());

        return redirect()->route('content-versions.index')
            ->with('success', 'Contenido diligenciado correctamente.');
    }

    public function show(ContentVersion $contentVersion)
    {
        $contentVersion->load(['content', 'version.project']);
        return view('content-versions.show', compact('contentVersion'));
    }

    public function edit(ContentVersion $contentVersion)
    {
        return view('content-versions.edit', compact('contentVersion'));
    }

    public function update(Request $request, ContentVersion $contentVersion)
    {
        $contentVersion->update($request->all());

        return redirect()->route('content-versions.index')
            ->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(ContentVersion $contentVersion)
    {
        $contentVersion->delete();

        return redirect()->route('content-versions.index')
            ->with('success', 'Registro eliminado correctamente.');
    }
}
