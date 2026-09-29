<?php

namespace App\Http\Controllers;

use App\Models\Pattern;

class PatternController extends Controller
{
    public function gallery()
    {
        return view('patterns.gallery', [
            'patterns' => Pattern::with('user')
                ->where('is_public', true)
                ->orderByDesc('is_featured')
                ->orderByDesc('likes_count')
                ->paginate(12),
        ]);
    }

    public function show(Pattern $pattern)
    {
        $user = auth()->user();
        abort_unless($pattern->is_public || ($user && (int) $pattern->user_id === (int) $user->id), 404);

        return view('patterns.show', [
            'pattern' => $pattern->load('user'),
        ]);
    }

    public function mine()
    {
        return view('patterns.mine', [
            'patterns' => Pattern::where('user_id', auth()->id())->latest()->get(),
        ]);
    }

    public function destroy(Pattern $pattern)
    {
        abort_unless((int) $pattern->user_id === (int) auth()->id(), 403);

        $pattern->delete();

        return redirect()->route('patterns.mine')->with('success', 'Pattern deleted.');
    }

    public function like(Pattern $pattern)
    {
        $user = auth()->user();
        $existing = $pattern->likes()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            $pattern->decrement('likes_count');
        } else {
            $pattern->likes()->create(['user_id' => $user->id]);
            $pattern->increment('likes_count');
        }

        return back();
    }
}