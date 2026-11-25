<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AiService
{
    protected array $faq = [
        'services' => 'LumenArc Home Cinema designs and installs custom home theaters, surround sound and acoustics, projector and screen systems, smart AV/lighting control, outdoor entertainment, and media racks with structured wiring across Austin, Round Rock, and nearby Central Texas communities.',
        'pricing' => 'Living-room AV upgrades often start around $4,500–$12,000. Dedicated theater rooms typically range $25,000–$85,000+ depending on acoustics, seating, projection, and control. Free design consults include a fixed proposal.',
        'timeline' => 'Design and site survey take 5–10 days. Standard living-room installs finish in 1–3 days. Dedicated theaters with acoustic build-outs usually take 3–8 weeks depending on trades.',
        'warranty' => 'Workmanship is covered for 5 years. Manufacturer warranties on displays, speakers, amplifiers, and control gear are passed through to the homeowner.',
        'areas' => 'We serve Austin, Round Rock, Cedar Park, Pflugerville, Westlake, Lakeway, Georgetown, and nearby Central Texas communities.',
        'prep' => 'Clear furniture from install walls, confirm Wi-Fi credentials for streaming devices, and park vehicles away from driveway staging. We can coordinate with painters and electricians if blackout or new circuits are needed.',
        'materials' => 'We specify calibrated displays or laser projectors, acoustic fabric and absorption, in-wall/in-ceiling speakers, ventilated media racks, and labeled structured wiring with service loops.',
    ];

    public function chat(string $message): string
    {
        $message = trim($message);
        if ($message === '') {
            return 'Ask anything about home theater design, surround sound, projectors, pricing ranges, or prep — I’m the LumenArc assistant.';
        }

        if ($key = config('services.openai.key')) {
            try {
                $response = Http::withToken($key)
                    ->timeout(20)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => config('services.openai.model', 'gpt-4o-mini'),
                        'messages' => [
                            [
                                'role' => 'system',
                                'content' => 'You are the helpful assistant for LumenArc Home Cinema, an Austin AV and home theater installer. Be concise, practical, and US-focused. Context: '.json_encode($this->faq),
                            ],
                            ['role' => 'user', 'content' => $message],
                        ],
                        'temperature' => 0.4,
                    ]);

                if ($response->successful()) {
                    return (string) data_get($response->json(), 'choices.0.message.content', $this->demoReply($message));
                }
            } catch (\Throwable) {
                // Fall through to demo knowledge base.
            }
        }

        return $this->demoReply($message);
    }

    public function generate(string $type, string $topic): string
    {
        $prompt = match ($type) {
            'blog' => "Write a short SEO blog post outline and intro about: {$topic}",
            'description' => "Write a product/service description for home theater / AV: {$topic}",
            'email' => "Write a customer follow-up email about: {$topic}",
            default => "Write helpful home theater and AV content about: {$topic}",
        };

        if (config('services.openai.key')) {
            return $this->chat($prompt);
        }

        return $this->demoContent($type, $topic);
    }

    public function automationSuggestions(): array
    {
        return [
            'Auto-send install prep checklists 48 hours before theater appointments.',
            'Flag jobs with estimated value over $25,000 for manager design review.',
            'Reorder HDMI matrix cables and speaker wire when stock drops below thresholds.',
            'Generate blog drafts from completed theater job titles weekly.',
            'SMS customers after final calibration for a Google review request.',
        ];
    }

    public function troubleshoot(string $issue): string
    {
        return $this->chat('Troubleshoot this home theater / AV / ERP issue: '.$issue);
    }

    protected function demoReply(string $message): string
    {
        $hay = Str::lower($message);

        foreach ([
            'price' => 'pricing',
            'pricing' => 'pricing',
            'cost' => 'pricing',
            'quote' => 'pricing',
            'how long' => 'timeline',
            'timeline' => 'timeline',
            'schedule' => 'timeline',
            'warrant' => 'warranty',
            'area' => 'areas',
            'serve' => 'areas',
            'austin' => 'areas',
            'prep' => 'prep',
            'clear' => 'prep',
            'material' => 'materials',
            'speaker' => 'materials',
            'projector' => 'materials',
            'service' => 'services',
            'install' => 'services',
            'theater' => 'services',
            'surround' => 'services',
        ] as $needle => $key) {
            if (Str::contains($hay, $needle)) {
                return $this->faq[$key];
            }
        }

        return $this->faq['services'].' For a free design consult in the Austin area, use the contact form or WhatsApp — living-room upgrades often start near $4,500.';
    }

    protected function demoContent(string $type, string $topic): string
    {
        return match ($type) {
            'blog' => "## {$topic}\n\nAustin homeowners are upgrading media rooms with calibrated picture, managed bass, and one-touch scenes. Start with seating sightlines and ambient light — then size speakers and screens to the room.\n\n### Outline\n1. Measure throw distance and seating row\n2. Choose display vs projection\n3. Plan speaker and sub locations\n4. Document the rack and cable plant",
            'description' => "LumenArc {$topic}: calibrated AV engineered for Central Texas homes. Acoustic-aware, serviceable racks, and installed by our Austin crew with a 5-year workmanship warranty.",
            'email' => "Hi there,\n\nThanks for considering LumenArc Home Cinema for {$topic}. Attached is your room concept and fixed proposal. Reply with a preferred install window and we will lock your crew.\n\n— LumenArc Team",
            default => "Demo AI content for {$topic}. Add OPENAI_API_KEY for live generation.",
        };
    }
}
