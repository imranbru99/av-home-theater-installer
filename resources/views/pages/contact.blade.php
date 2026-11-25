@extends('layouts.site')

@section('title', 'Contact')

@section('content')
<section>
    <div class="wrap grid-2">
        <div>
            <div class="eyebrow" style="color:var(--cyan-deep);">Contact</div>
            <h1>Book a free design consult</h1>
            <p class="muted">Tell us about your room size, seating goals, and preferred timeline. We reply within one business day.</p>
            <div class="panel" style="margin-top:1.2rem;">
                <p><strong>Phone:</strong> (512) 555-0194</p>
                <p><strong>Email:</strong> hello@lumenarchomecinema.com</p>
                <p><strong>Studio:</strong> 3801 S Lamar Blvd, Austin, TX 78704</p>
            </div>
        </div>
        <div class="panel">
            @if (session('success'))
                <div class="flash">{{ session('success') }}</div>
            @endif
            <form class="stack" method="post" action="{{ route('contact.store') }}">
                @csrf
                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<div class="muted">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}">
                </div>
                <div>
                    <label for="subject">Subject</label>
                    <input id="subject" name="subject" value="{{ old('subject') }}">
                </div>
                <div>
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                </div>
                <button class="btn btn-primary" type="submit">Send message</button>
            </form>
        </div>
    </div>
</section>
@endsection
