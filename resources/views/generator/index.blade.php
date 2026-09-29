@extends('layouts.app')

@section('title', 'Pattern generator')

@section('content')
<div class="row">
    <div class="col-md-4">
        <h3 class="mb-3">Design your pattern</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Symmetry</label>
            <select id="symmetry" class="form-select">
                <option value="4-fold">4-fold (square)</option>
                <option value="6-fold">6-fold (hexagonal)</option>
                <option value="8-fold" selected>8-fold (star)</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Motif</label>
            <select id="shape" class="form-select">
                <option value="star" selected>Star</option>
                <option value="diamond">Diamond</option>
                <option value="knot">Knot</option>
                <option value="floral">Floral</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Grid density: <span id="densityLabel">6</span></label>
            <input type="range" id="density" class="form-range" min="2" max="16" value="6">
        </div>

        <div class="mb-3">
            <label class="form-label">Colors</label>
            <div class="d-flex gap-2 flex-wrap">
                <input type="color" id="color1" class="form-control form-control-color" value="#1e3a8a">
                <input type="color" id="color2" class="form-control form-control-color" value="#ffffff">
                <input type="color" id="color3" class="form-control form-control-color" value="#60a5fa">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Presets</label>
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-sm btn-outline-light preset" data-colors="#1e3a8a,#ffffff,#60a5fa">Fès blue</button>
                <button type="button" class="btn btn-sm btn-outline-light preset" data-colors="#7f1d1d,#f59e0b,#fef3c7">Marrakech red</button>
                <button type="button" class="btn btn-sm btn-outline-light preset" data-colors="#1e40af,#0ea5e9,#e0f2fe">Chefchaouen blue</button>
            </div>
        </div>

        <button type="button" id="randomize" class="btn btn-outline-warning w-100 mb-3">🎲 Randomize</button>

        <hr>

        <form method="POST" action="{{ route('patterns.store') }}">
            @csrf
            <input type="hidden" name="symmetry_type" id="fSymmetry">
            <input type="hidden" name="base_shape" id="fShape">
            <input type="hidden" name="grid_density" id="fDensity">
            <input type="hidden" name="colors[]" id="fColor1">
            <input type="hidden" name="colors[]" id="fColor2">
            <input type="hidden" name="colors[]" id="fColor3">

            <div class="mb-3">
                <label class="form-label">Title (optional)</label>
                <input type="text" name="title" class="form-control" placeholder="My pattern" maxlength="100">
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="is_public" value="1" id="isPublic" checked>
                <label class="form-check-label" for="isPublic">Share in the public gallery</label>
            </div>
            <button class="btn btn-primary w-100">💾 Save pattern</button>
        </form>
    </div>

    <div class="col-md-8 text-center">
        <canvas id="canvas" width="600" height="600" class="border rounded" style="max-width: 100%; background: #f5f1e8;"></canvas>
        <div class="mt-2">
            <button type="button" id="download" class="btn btn-sm btn-outline-light">⬇️ Download PNG</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/pattern-renderer.js') }}"></script>
<script>
    const canvas = document.getElementById('canvas');
    const symmetryEl = document.getElementById('symmetry');
    const shapeEl = document.getElementById('shape');
    const densityEl = document.getElementById('density');
    const densityLabel = document.getElementById('densityLabel');
    const color1 = document.getElementById('color1');
    const color2 = document.getElementById('color2');
    const color3 = document.getElementById('color3');

    function currentOptions() {
        return {
            symmetry: symmetryEl.value,
            shape: shapeEl.value,
            density: parseInt(densityEl.value, 10),
            colors: [color1.value, color2.value, color3.value],
        };
    }

    function redraw() {
        densityLabel.textContent = densityEl.value;
        window.RasmaRenderer.render(canvas, currentOptions());
    }

    [symmetryEl, shapeEl, densityEl, color1, color2, color3].forEach(function (el) {
        el.addEventListener('input', redraw);
    });

    document.querySelectorAll('.preset').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const parts = btn.dataset.colors.split(',');
            color1.value = parts[0];
            color2.value = parts[1];
            color3.value = parts[2];
            redraw();
        });
    });

    document.getElementById('randomize').addEventListener('click', function () {
        const symmetries = ['4-fold', '6-fold', '8-fold'];
        const shapes = ['star', 'diamond', 'knot', 'floral'];
        symmetryEl.value = symmetries[Math.floor(Math.random() * symmetries.length)];
        shapeEl.value = shapes[Math.floor(Math.random() * shapes.length)];
        densityEl.value = 2 + Math.floor(Math.random() * 10);
        const rndColor = () => '#' + Math.floor(Math.random() * 0xffffff).toString(16).padStart(6, '0');
        color1.value = rndColor();
        color2.value = rndColor();
        color3.value = rndColor();
        redraw();
    });

    document.getElementById('download').addEventListener('click', function () {
        const link = document.createElement('a');
        link.download = 'rasma-dyali-pattern.png';
        link.href = canvas.toDataURL('image/png');
        link.click();
    });

    document.querySelector('form[action="{{ route('patterns.store') }}"]').addEventListener('submit', function () {
        document.getElementById('fSymmetry').value = symmetryEl.value;
        document.getElementById('fShape').value = shapeEl.value;
        document.getElementById('fDensity').value = densityEl.value;
        document.getElementById('fColor1').value = color1.value;
        document.getElementById('fColor2').value = color2.value;
        document.getElementById('fColor3').value = color3.value;
    });

    redraw();
</script>
@endpush