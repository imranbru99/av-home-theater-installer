<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LumenArc Home Cinema') — Austin AV & Home Theater</title>
    <meta name="description" content="@yield('meta', 'LumenArc Home Cinema designs and installs custom home theaters, surround sound, projectors, and smart AV systems across Austin and Round Rock.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --ink: #0A1628;
            --steel: #132238;
            --cyan: #22D3EE;
            --cyan-deep: #0891B2;
            --gold: #E8B86D;
            --mist: #E8F4F8;
            --fog: #F0F7FA;
            --muted: #64748B;
            --white: #FFFFFF;
            --shadow: 0 24px 60px rgba(10, 22, 40, 0.22);
            --font-display: "Syne", sans-serif;
            --font-body: "Outfit", sans-serif;
        }
        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: var(--font-body);
            color: var(--ink);
            background:
                radial-gradient(circle at 8% -8%, rgba(34,211,238,.16), transparent 40%),
                radial-gradient(circle at 92% 6%, rgba(232,184,109,.14), transparent 34%),
                linear-gradient(180deg, #F5FBFD 0%, #EAF3F7 48%, #F5FBFD 100%);
            line-height: 1.6;
        }
        a { color: inherit; text-decoration: none; }
        img { max-width: 100%; display: block; }
        .wrap { width: min(1120px, calc(100% - 2rem)); margin-inline: auto; }
        .site-header {
            position: sticky; top: 0; z-index: 40;
            backdrop-filter: blur(14px);
            background: rgba(10, 22, 40, 0.9);
            border-bottom: 1px solid rgba(34,211,238,.12);
        }
        .nav {
            display: flex; align-items: center; justify-content: space-between;
            gap: 1rem; padding: .95rem 0;
        }
        .brand {
            font-family: var(--font-display);
            letter-spacing: .02em;
            color: var(--white);
            font-size: 1.3rem;
            font-weight: 800;
            display: flex; align-items: baseline; gap: .3rem;
        }
        .brand span { color: var(--cyan); }
        .nav-links { display: flex; flex-wrap: wrap; gap: .9rem 1.15rem; align-items: center; }
        .nav-links a { color: #C5D4E0; font-size: .92rem; font-weight: 500; }
        .nav-links a:hover { color: var(--cyan); }
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            gap: .4rem; border: 0; cursor: pointer;
            border-radius: .55rem; padding: .78rem 1.25rem;
            font-weight: 700; font-size: .95rem;
            transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .btn:hover { transform: translateY(-1px); }
        .btn-primary { background: linear-gradient(135deg, var(--cyan-deep), var(--cyan)); color: #042028; box-shadow: 0 10px 28px rgba(34,211,238,.35); }
        .btn-ghost { background: transparent; color: var(--white); border: 1px solid rgba(255,255,255,.28); }
        .btn-dark { background: var(--ink); color: var(--white); }
        .hero {
            position: relative; min-height: min(92vh, 780px);
            display: grid; align-items: end;
            color: var(--white);
            overflow: hidden;
            background: #060D18;
        }
        .hero-media {
            position: absolute; inset: 0;
            background:
                linear-gradient(95deg, rgba(6,13,24,.92) 0%, rgba(6,13,24,.55) 45%, rgba(6,13,24,.25) 100%),
                url('https://images.unsplash.com/photo-1593784991095-a20506947072?auto=format&fit=crop&w=1800&q=80') center/cover no-repeat;
            transform: scale(1.04);
            animation: drift 18s ease-in-out infinite alternate;
        }
        @keyframes drift { from { transform: scale(1.04) translateY(0); } to { transform: scale(1.08) translateY(-1.5%); } }
        .hero-copy { position: relative; z-index: 1; padding: 7rem 0 4.5rem; width: min(720px, 100%); }
        .eyebrow {
            display: inline-block; margin-bottom: .85rem;
            color: var(--cyan); font-weight: 700; letter-spacing: .14em;
            text-transform: uppercase; font-size: .78rem;
        }
        h1, h2, h3 { font-family: var(--font-display); letter-spacing: -.01em; line-height: 1.1; margin: 0 0 .75rem; }
        h1 { font-size: clamp(2.6rem, 6.5vw, 4.6rem); }
        h2 { font-size: clamp(1.9rem, 3.8vw, 2.85rem); }
        h3 { font-size: 1.4rem; }
        .lede { font-size: 1.1rem; color: #C8D5E0; max-width: 36rem; margin-bottom: 1.5rem; }
        .cta-row { display: flex; flex-wrap: wrap; gap: .8rem; }
        section { padding: 4.5rem 0; }
        .section-head { max-width: 40rem; margin-bottom: 2rem; }
        .muted { color: var(--muted); }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .service-tile {
            position: relative; overflow: hidden; min-height: 280px;
            border-radius: 1.1rem; color: white;
            isolation: isolate;
            transition: transform .25s ease;
        }
        .service-tile:hover { transform: translateY(-4px); }
        .service-tile img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: -2; }
        .service-tile::after {
            content: ""; position: absolute; inset: 0; z-index: -1;
            background: linear-gradient(180deg, rgba(10,22,40,.12), rgba(10,22,40,.9));
        }
        .service-tile .inner { position: absolute; left: 0; right: 0; bottom: 0; padding: 1.25rem; }
        .panel {
            background: rgba(255,255,255,.74);
            border: 1px solid rgba(19,34,56,.08);
            border-radius: 1.2rem;
            padding: 1.4rem;
            box-shadow: var(--shadow);
        }
        .dashboard-preview {
            display: grid; grid-template-columns: 1.1fr .9fr; gap: 1rem;
            background: linear-gradient(145deg, #0A1628, #16304A);
            color: white; border-radius: 1.4rem; padding: 1.4rem;
            box-shadow: var(--shadow);
        }
        .dash-stat { background: rgba(255,255,255,.06); border-radius: 1rem; padding: 1rem; }
        .dash-stat strong { display: block; font-size: 1.7rem; font-family: var(--font-display); color: var(--cyan); }
        .bars { display: flex; align-items: end; gap: .45rem; height: 120px; margin-top: 1rem; }
        .bars span {
            flex: 1; border-radius: .4rem .4rem 0 0;
            background: linear-gradient(180deg, var(--cyan), var(--gold));
            animation: rise 1.4s ease both;
        }
        @keyframes rise { from { transform: scaleY(.2); transform-origin: bottom; opacity: .4; } to { transform: scaleY(1); opacity: 1; } }
        .about-band {
            display: grid; grid-template-columns: 1.05fr .95fr; gap: 2rem; align-items: center;
        }
        .about-band img { width: 100%; height: 420px; object-fit: cover; border-radius: 1.4rem; }
        form.stack { display: grid; gap: .85rem; }
        label { font-weight: 600; font-size: .92rem; }
        input, textarea, select {
            width: 100%; border: 1px solid #CBD5E1; border-radius: .8rem;
            padding: .85rem 1rem; font: inherit; background: white;
        }
        textarea { min-height: 140px; resize: vertical; }
        .flash {
            background: #ECFEFF; color: #155E75; border: 1px solid #A5F3FC;
            padding: .9rem 1rem; border-radius: .9rem; margin-bottom: 1rem;
        }
        .site-footer {
            background: var(--ink); color: #B8C7D4; padding: 3rem 0 2rem; margin-top: 2rem;
        }
        .footer-grid { display: grid; grid-template-columns: 1.4fr 1fr 1fr; gap: 1.5rem; }
        .site-footer a:hover { color: var(--cyan); }
        .whatsapp {
            position: fixed; right: 1.1rem; bottom: 1.1rem; z-index: 50;
            width: 58px; height: 58px; border-radius: 50%;
            display: grid; place-items: center;
            background: #25D366; color: white; font-weight: 800;
            box-shadow: 0 12px 30px rgba(37,211,102,.45);
            animation: pulse 2.4s ease-in-out infinite;
        }
        @keyframes pulse { 0%,100% { transform: scale(1); } 50% { transform: scale(1.06); } }
        .chat-widget {
            position: fixed; left: 1.1rem; bottom: 1.1rem; z-index: 50; width: min(340px, calc(100vw - 2rem));
        }
        .chat-toggle {
            background: var(--cyan-deep); color: white; border: 0; border-radius: .55rem;
            padding: .8rem 1.1rem; font-weight: 700; cursor: pointer; box-shadow: var(--shadow);
        }
        .chat-panel {
            display: none; margin-bottom: .7rem; background: white; border-radius: 1rem;
            overflow: hidden; box-shadow: var(--shadow); border: 1px solid #E2E8F0;
        }
        .chat-panel.open { display: block; animation: slideUp .25s ease; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }
        .chat-head { background: var(--steel); color: white; padding: .85rem 1rem; font-weight: 700; }
        .chat-log { height: 220px; overflow: auto; padding: .9rem; background: var(--fog); font-size: .92rem; }
        .chat-log .bot, .chat-log .user { margin-bottom: .65rem; padding: .65rem .75rem; border-radius: .75rem; max-width: 90%; }
        .chat-log .bot { background: white; border: 1px solid #E2E8F0; }
        .chat-log .user { background: #CFFAFE; margin-left: auto; }
        .chat-form { display: flex; gap: .4rem; padding: .65rem; }
        .chat-form input { flex: 1; }
        .prose { max-width: 48rem; }
        .prose p { margin: 0 0 1rem; }
        .card-list { display: grid; gap: 1rem; }
        .post-card, .kb-card {
            background: rgba(255,255,255,.8); border-radius: 1rem; overflow: hidden;
            border: 1px solid rgba(19,34,56,.08); box-shadow: 0 10px 30px rgba(10,22,40,.06);
        }
        .post-card img { height: 180px; width: 100%; object-fit: cover; }
        .post-card .body, .kb-card { padding: 1.1rem 1.2rem; }
        @media (max-width: 900px) {
            .grid-3, .grid-2, .about-band, .dashboard-preview, .footer-grid { grid-template-columns: 1fr; }
            .about-band img { height: 280px; }
            .nav-links { display: none; }
            .hero-copy { padding-top: 5.5rem; }
        }
    </style>
    @stack('head')
</head>
<body>
<header class="site-header">
    <div class="wrap nav">
        <a class="brand" href="{{ route('home') }}">Lumen<span>Arc</span></a>
        <nav class="nav-links">
            <a href="{{ route('services.index') }}">Services</a>
            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('blog.index') }}">Blog</a>
            <a href="{{ route('kb.index') }}">Knowledge Base</a>
            <a href="{{ route('contact') }}">Contact</a>
            <a href="/admin" class="btn btn-ghost" style="padding:.55rem 1rem;">ERP Login</a>
        </nav>
        <a class="btn btn-primary" href="{{ route('contact') }}">Free Design Consult</a>
    </div>
</header>

<main>@yield('content')</main>

<footer class="site-footer">
    <div class="wrap footer-grid">
        <div>
            <div class="brand" style="margin-bottom:.6rem;">Lumen<span>Arc</span> Home Cinema</div>
            <p>Custom home theaters, surround sound, projectors, and smart AV for Austin and the Round Rock metro.</p>
        </div>
        <div>
            <h3 style="color:white;">Visit</h3>
            <p>3801 S Lamar Blvd<br>Austin, TX 78704<br>(512) 555-0194</p>
        </div>
        <div>
            <h3 style="color:white;">Explore</h3>
            <p><a href="{{ route('services.index') }}">Services</a><br>
            <a href="{{ route('kb.index') }}">Knowledge Base</a><br>
            <a href="{{ route('contact') }}">Contact</a></p>
        </div>
    </div>
</footer>

<a class="whatsapp" href="https://wa.me/15125550194" target="_blank" rel="noopener" aria-label="WhatsApp">WA</a>

<div class="chat-widget">
    <div id="chat-panel" class="chat-panel">
        <div class="chat-head">LumenArc Assistant</div>
        <div id="chat-log" class="chat-log">
            <div class="bot">Ask about dedicated theaters, surround sound, projectors, pricing ranges, or prep for install day.</div>
        </div>
        <form id="chat-form" class="chat-form">
            <input id="chat-input" type="text" placeholder="Type a question..." required>
            <button class="btn btn-primary" type="submit" style="padding:.7rem 0.9rem;">Send</button>
        </form>
    </div>
    <button class="chat-toggle" id="chat-toggle" type="button">Chat with AI</button>
</div>

<script>
(() => {
    const toggle = document.getElementById('chat-toggle');
    const panel = document.getElementById('chat-panel');
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const log = document.getElementById('chat-log');
    toggle.addEventListener('click', () => panel.classList.toggle('open'));
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = input.value.trim();
        if (!message) return;
        log.insertAdjacentHTML('beforeend', `<div class="user"></div>`);
        log.lastElementChild.textContent = message;
        input.value = '';
        const res = await fetch('{{ route('ai.chat') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message })
        });
        const data = await res.json();
        log.insertAdjacentHTML('beforeend', `<div class="bot"></div>`);
        log.lastElementChild.textContent = data.reply || 'Sorry, try again.';
        log.scrollTop = log.scrollHeight;
    });
})();
</script>
@stack('scripts')
</body>
</html>
