@extends('layouts.site')

@section('title', 'Services')

@section('content')
<section>
    <div class="wrap">
        <div class="section-head">
            <div class="eyebrow" style="color:var(--gold);">Services</div>
            <h1>AV & home theater services</h1>
            <p class="muted">From a living-room upgrade to a blacked-out dedicated cinema — engineered for Austin homes.</p>
        </div>
        <div class="grid-2">
            @foreach ([
                ['dedicated-theater-rooms', 'Dedicated Theater Rooms', 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1000&q=80', 'Full blackout rooms with seating risers, acoustic fabric, and calibrated picture.'],
                ['surround-sound-acoustics', 'Surround Sound & Acoustics', 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=1000&q=80', 'Immersive speaker layouts, bass management, and treatment that tames Texas drywall bounce.'],
                ['projector-screen-systems', 'Projector & Screen Systems', 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&w=1000&q=80', 'Laser projectors, tensioned screens, and light-controlled throws for true cinema scale.'],
                ['smart-av-control', 'Smart AV & Lighting Control', 'https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&w=1000&q=80', 'One-touch scenes for movie night, gaming, and streaming across the home.'],
                ['outdoor-entertainment', 'Outdoor Entertainment', 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?auto=format&fit=crop&w=1000&q=80', 'Weather-ready screens, patio audio, and poolside viewing built for Hill Country evenings.'],
                ['media-racks-wiring', 'Media Racks & Structured Wiring', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1000&q=80', 'Ventilated racks, labeled cable plants, and service loops that keep future upgrades sane.'],
            ] as [$slug, $title, $img, $summary])
                <a class="post-card" href="{{ route('services.show', $slug) }}">
                    <img src="{{ $img }}" alt="{{ $title }}">
                    <div class="body">
                        <h3>{{ $title }}</h3>
                        <p class="muted">{{ $summary }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
