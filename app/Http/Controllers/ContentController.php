<?php
namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $contents = Content::orderBy('name')->paginate(15);
        return view('contents.index', compact('contents'));
    }

    public function create()
    {
        return view('contents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'roles'        => 'nullable|string|max:255',
        ]);

        Content::create($data);

        return redirect()->route('contents.index')->with('success', 'Contenido creado correctamente.');
    }

    public function show(Content $content)
    {
        $content->load('versions');
        return view('contents.show', compact('content'));
    }

    public function edit(Content $content)
    {
        return view('contents.edit', compact('content'));
    }

    public function update(Request $request, Content $content)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'roles'        => 'nullable|string|max:255',
        ]);

        $content->update($data);

        return redirect()->route('contents.index')->with('success', 'Contenido actualizado correctamente.');
    }

    public function destroy(Content $content)
    {
        if ($content->contentVersions()->exists()) {
            return back()->with('error', 'No es posible eliminar el contenido porque tiene versiones asociadas.');
        }

        $content->delete();
        return redirect()->route('contents.index')->with('success', 'Contenido eliminado correctamente.');
    }
}
