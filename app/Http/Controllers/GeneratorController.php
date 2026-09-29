<?php

namespace App\Http\Controllers;

use App\Models\Pattern;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GeneratorController extends Controller
{
    public function index()
    {
        return view('generator.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:100'],
            'symmetry_type' => ['required', Rule::in(Pattern::SYMMETRIES)],
            'base_shape' => ['required', Rule::in(Pattern::SHAPES)],
            'colors' => ['required', 'array', 'min:2', 'max:4'],
            'colors.*' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'grid_density' => ['required', 'integer', 'min:2', 'max:16'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $pattern = Pattern::create([
            'user_id' => auth()->id(),
            'title' => $data['title'] ?: 'Untitled pattern',
            'symmetry_type' => $data['symmetry_type'],
            'base_shape' => $data['base_shape'],
            'colors' => $data['colors'],
            'grid_density' => $data['grid_density'],
            'is_public' => $request->boolean('is_public'),
        ]);

        return redirect()->route('patterns.show', $pattern)->with('success', 'Pattern saved!');
    }
}