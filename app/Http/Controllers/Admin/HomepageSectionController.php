<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomepageSectionController extends Controller
{
    public function index()
    {
        return view('admin.homepage.index', [
            'sections' => HomepageSection::ordered()->get(),
        ]);
    }

    /** Persist drag-and-drop ordering: expects {order: [id, id, ...]}. */
    public function reorder(Request $request)
    {
        $request->validate(['order' => ['required', 'array'], 'order.*' => ['integer']]);

        foreach ($request->input('order') as $position => $id) {
            HomepageSection::where('id', $id)->update(['display_order' => $position + 1]);
        }

        return response()->json(['ok' => true]);
    }

    public function toggle(HomepageSection $section)
    {
        $section->update(['is_active' => ! $section->is_active]);

        return back()->with('success', $section->is_active ? 'Section enabled.' : 'Section disabled.');
    }
}
