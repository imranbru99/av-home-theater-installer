<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\KnowledgeArticle;
use App\Models\Post;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->take(3)->get();

        return view('pages.home', compact('posts'));
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function services(): View
    {
        return view('services.index');
    }

    public function serviceShow(string $slug): View
    {
        $services = $this->serviceCatalog();
        abort_unless(isset($services[$slug]), 404);

        return view('services.show', [
            'slug' => $slug,
            'service' => $services[$slug],
            'services' => $services,
        ]);
    }

    public function blog(): View
    {
        $posts = Post::query()->where('is_published', true)->latest('published_at')->paginate(9);

        return view('blog.index', compact('posts'));
    }

    public function blogShow(string $slug): View
    {
        $post = Post::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function knowledge(): View
    {
        $articles = KnowledgeArticle::query()->where('is_published', true)->orderBy('sort_order')->get()->groupBy('category');

        return view('kb.index', compact('articles'));
    }

    public function knowledgeShow(string $slug): View
    {
        $article = KnowledgeArticle::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('kb.show', compact('article'));
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::query()->create($data);

        return back()->with('success', 'Thanks — LumenArc received your message and will reply within one business day.');
    }

    public function chat(Request $request, AiService $ai)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        return response()->json([
            'reply' => $ai->chat($data['message']),
        ]);
    }

    protected function serviceCatalog(): array
    {
        return [
            'dedicated-theater-rooms' => [
                'title' => 'Dedicated Theater Rooms',
                'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'Full blackout rooms with seating risers, acoustic fabric, and calibrated picture.',
                'body' => 'We design dedicated cinemas from shell to first screening: riser layout, acoustic treatments, blackout, seating, and a calibrated projection or OLED wall. LumenArc documents rack elevations and speaker positions so future service stays simple.',
            ],
            'surround-sound-acoustics' => [
                'title' => 'Surround Sound & Acoustics',
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'Immersive speaker layouts, bass management, and treatment that tames drywall bounce.',
                'body' => 'From 5.1 upgrades to Atmos height channels, we place speakers for even coverage, manage bass modes common in Texas slab homes, and add absorption/diffusion where reflections steal clarity.',
            ],
            'projector-screen-systems' => [
                'title' => 'Projector & Screen Systems',
                'image' => 'https://images.unsplash.com/photo-1517604931442-7e0c8ed2963c?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'Laser projectors, tensioned screens, and light-controlled throws for cinema scale.',
                'body' => 'We match throw distance, screen gain, and ambient light control so blacks stay deep. Ceiling mounts, conduit paths, and cooling are planned before the first hole is cut.',
            ],
            'smart-av-control' => [
                'title' => 'Smart AV & Lighting Control',
                'image' => 'https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'One-touch scenes for movie night, gaming, and streaming across the home.',
                'body' => 'Unified remotes and lighting scenes dim the room, fire the display, and route audio without hunting for five remotes. Ideal for multi-room audio and family-friendly presets.',
            ],
            'outdoor-entertainment' => [
                'title' => 'Outdoor Entertainment',
                'image' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'Weather-ready screens, patio audio, and poolside viewing for Hill Country evenings.',
                'body' => 'Outdoor AV needs shade, IP-rated gear, and thoughtful mounting. We design patio systems that survive Austin summers and still sound clear for game day.',
            ],
            'media-racks-wiring' => [
                'title' => 'Media Racks & Structured Wiring',
                'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&w=1400&q=80',
                'summary' => 'Ventilated racks, labeled cable plants, and service loops for future upgrades.',
                'body' => 'Clean racks keep gear cool and serviceable. We label every run, leave service loops, and document the plant so upgrades do not become demolition projects.',
            ],
        ];
    }
}
