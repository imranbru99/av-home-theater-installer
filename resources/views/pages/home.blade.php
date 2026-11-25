@extends('layouts.site')

@section('title', 'LumenArc Home Cinema')
@section('meta', 'Custom home theaters, surround sound, projectors, and smart AV installs for Austin and Round Rock.')

@section('content')
<section class="hero">
    <div class="hero-media" aria-hidden="true"></div>
    <div class="wrap hero-copy">
        <div class="eyebrow">Austin AV & Home Theater</div>
        <h1>LumenArc Home Cinema</h1>
        <p class="lede">Dedicated theaters, calibrated surround sound, and smart control — engineered for Texas homes that want cinema nights without compromise.</p>
        <div class="cta-row">
            <a class="btn btn-primary" href="{{ route('contact') }}">Book a free design consult</a>
            <a class="btn btn-ghost" href="{{ route('services.index') }}">Explore services</a>
        </div>
    </div>
</section>

<section>
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow" style="color:var(--cyan-deep);">Services</div>
            <h2>Rooms that disappear into the movie</h2>
            <p class="muted">One focus per space — picture, sound, light control, and clean racks that stay serviceable.</p>
        </div>
        <div class="grid-3">
            @foreach ([
                ['dedicated-theater-rooms', 'Dedicated Theaters', 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=900&q=80'],
                ['surround-sound-acoustics', 'Surround & Acoustics', 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=900&q=80'],
                ['projector-screen-systems', 'Projector Systems', 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&w=900&q=80'],
            ] as [$slug, $title, $img])
                <a class="service-tile" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="inner">
                        <h3>{{ $title }}</h3>
                        <p style="margin:0;opacity:.9;">See details →</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<section style="padding-top:0;">
    <div class="wrap about-band">
        <div>
            <div class="eyebrow" style="color:var(--gold);">About LumenArc</div>
            <h2>Built for real Austin media rooms</h2>
            <p class="muted">We map seating sightlines, speaker placement, HVAC noise, and how your family actually watches — then install systems that stay calibrated through Texas heat and streaming binge nights.</p>
            <p class="muted">Every proposal includes a fixed scope, rack drawings, and a prep checklist so install day stays clean and predictable.</p>
            <a class="btn btn-dark" href="{{ route('about') }}">Our story</a>
        </div>
        <img src="https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?auto=format&fit=crop&w=1200&q=80" alt="Modern living room television setup">
    </div>
</section>

<section>
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow" style="color:var(--cyan-deep);">ERP preview</div>
            <h2>Operations dashboard</h2>
            <p class="muted">The same Filament ERP your crew uses for jobs, inventory, invoices, and AI assist.</p>
        </div>
        <div class="dashboard-preview">
            <div>
                <div class="grid-2" style="margin-bottom:1rem;">
                    <div class="dash-stat"><strong>18</strong>Active installs</div>
                    <div class="dash-stat"><strong>$142k</strong>Collected MTD</div>
                </div>
                <div class="bars" aria-hidden="true">
                    <span style="height:45%"></span>
                    <span style="height:70%"></span>
                    <span style="height:55%"></span>
                    <span style="height:88%"></span>
                    <span style="height:62%"></span>
                    <span style="height:76%"></span>
                </div>
            </div>
            <div class="panel" style="background:rgba(255,255,255,.08);color:#E2E8F0;box-shadow:none;border-color:rgba(255,255,255,.08);">
                <h3 style="color:white;">Today’s schedule</h3>
                <p>08:30 — Acoustic survey, Westlake</p>
                <p>11:00 — Projector & screen hang, Round Rock</p>
                <p>14:30 — Surround calibration, Mueller</p>
                <a class="btn btn-primary" href="/admin" style="margin-top:.5rem;">Open admin</a>
            </div>
        </div>
    </div>
</section>

<section style="padding-top:0;">
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow" style="color:var(--gold);">From the booth</div>
            <h2>Knowledge & blog</h2>
        </div>
        <div class="grid-3">
            @foreach ($posts as $post)
                <article class="post-card">
                    @if ($post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}">
                    @endif
                    <div class="body">
                        <h3><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
                        <p class="muted">{{ $post->excerpt }}</p>
                    </div>
                </article>
            @endforeach
        </div>
        <div style="margin-top:1.5rem;">
            <a class="btn btn-dark" href="{{ route('contact') }}">Talk to LumenArc</a>
        </div>
    </div>
</section>
@endsection
