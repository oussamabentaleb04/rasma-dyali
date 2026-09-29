function drawStar(ctx, size, points, color) {
    const inner = size * 0.45;
    ctx.beginPath();
    for (let i = 0; i < points * 2; i++) {
        const r = i % 2 === 0 ? size : inner;
        const a = (i * Math.PI) / points - Math.PI / 2;
        const x = r * Math.cos(a), y = r * Math.sin(a);
        i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
    }
    ctx.closePath();
    ctx.fillStyle = color;
    ctx.fill();
}

function drawDiamond(ctx, size, color) {
    ctx.beginPath();
    ctx.moveTo(0, -size);
    ctx.lineTo(size * 0.6, 0);
    ctx.lineTo(0, size);
    ctx.lineTo(-size * 0.6, 0);
    ctx.closePath();
    ctx.fillStyle = color;
    ctx.fill();
}

function drawKnot(ctx, size, points, color) {
    ctx.beginPath();
    const steps = 200;
    for (let i = 0; i <= steps; i++) {
        const t = (i / steps) * Math.PI * 2;
        const r = size * Math.cos((points * t) / 2);
        const x = r * Math.cos(t), y = r * Math.sin(t);
        i === 0 ? ctx.moveTo(x, y) : ctx.lineTo(x, y);
    }
    ctx.strokeStyle = color;
    ctx.lineWidth = Math.max(1, size * 0.12);
    ctx.lineCap = 'round';
    ctx.stroke();
}

function drawFloral(ctx, size, points, color) {
    for (let i = 0; i < points; i++) {
        const a = i * ((2 * Math.PI) / points);
        ctx.save();
        ctx.rotate(a);
        ctx.beginPath();
        ctx.ellipse(0, -size * 0.5, size * 0.3, size * 0.5, 0, 0, Math.PI * 2);
        ctx.fillStyle = color;
        ctx.fill();
        ctx.restore();
    }
    ctx.beginPath();
    ctx.arc(0, 0, size * 0.25, 0, Math.PI * 2);
    ctx.fillStyle = color;
    ctx.fill();
}

function drawMotif(ctx, shape, size, points, color) {
    if (shape === 'star') drawStar(ctx, size, points, color);
    else if (shape === 'diamond') drawDiamond(ctx, size, color);
    else if (shape === 'knot') drawKnot(ctx, size, points, color);
    else if (shape === 'floral') drawFloral(ctx, size, points, color);
}

// symmetry_type values look like "4-fold" — parseInt stops at the dash
// and returns 4, so we can pass the field straight in.
window.RasmaRenderer = {
    render: function (canvas, opts) {
        const ctx = canvas.getContext('2d');
        const size = canvas.width;
        ctx.clearRect(0, 0, size, size);
        ctx.fillStyle = '#f5f1e8';
        ctx.fillRect(0, 0, size, size);

        const N = parseInt(opts.symmetry, 10);
        const density = opts.density;
        const colors = opts.colors;
        const cx = size / 2, cy = size / 2;
        const maxR = size / 2 - 20;

        ctx.save();
        ctx.translate(cx, cy);

        drawMotif(ctx, opts.shape, (maxR / density) * 0.5, N, colors[0]);

        for (let ring = 1; ring <= density; ring++) {
            const radius = (maxR / density) * ring;
            const motifSize = (maxR / density) * 0.9;
            const offset = ring % 2 === 0 ? Math.PI / N : 0;

            for (let i = 0; i < N; i++) {
                const angle = i * ((2 * Math.PI) / N) + offset;
                const x = radius * Math.cos(angle), y = radius * Math.sin(angle);
                const color = colors[(ring + i) % colors.length];
                ctx.save();
                ctx.translate(x, y);
                ctx.rotate(angle + Math.PI / 2);
                drawMotif(ctx, opts.shape, motifSize / 2, N, color);
                ctx.restore();
            }
        }
        ctx.restore();
    },
};