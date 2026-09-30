<?php

namespace App\Http\Controllers;

use App\Models\Pattern;

class AdminPatternController extends Controller
{
    public function index()
    {
        return view('admin.patterns.index', [
            'patterns' => Pattern::with('user')->latest()->paginate(20),
        ]);
    }

    public function toggleFeatured(Pattern $pattern)
    {
        $pattern->update(['is_featured' => ! $pattern->is_featured]);

        return back()->with('success', $pattern->is_featured ? 'Pattern featured.' : 'Pattern unfeatured.');
    }

    public function togglePublic(Pattern $pattern)
    {
        $pattern->update(['is_public' => ! $pattern->is_public]);

        return back()->with('success', $pattern->is_public ? 'Pattern shown in gallery.' : 'Pattern hidden from gallery.');
    }

    public function destroy(Pattern $pattern)
    {
        $pattern->delete();

        return back()->with('success', 'Pattern deleted.');
    }
}