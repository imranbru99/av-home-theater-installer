<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\KnowledgeArticle;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['admin', 'manager', 'staff'] as $role) {
            Role::findOrCreate($role);
        }

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'LumenArc Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '(512) 555-0101',
            ]
        );
        $admin->assignRole('admin');

        $manager = User::query()->updateOrCreate(
            ['email' => 'manager@lumenarchomecinema.com'],
            [
                'name' => 'Elena Vargas',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'phone' => '(512) 555-0102',
            ]
        );
        $manager->assignRole('manager');

        $staff = User::query()->updateOrCreate(
            ['email' => 'staff@lumenarchomecinema.com'],
            [
                'name' => 'Marcus Cole',
                'password' => Hash::make('password'),
                'role' => 'staff',
                'phone' => '(512) 555-0103',
            ]
        );
        $staff->assignRole('staff');

        $settings = [
            'company_name' => 'LumenArc Home Cinema',
            'tagline' => 'Custom home theaters & AV for Texas living',
            'phone' => '(512) 555-0194',
            'email' => 'hello@lumenarchomecinema.com',
            'address' => '3801 S Lamar Blvd, Austin, TX 78704',
            'whatsapp' => '15125550194',
        ];
        foreach ($settings as $key => $value) {
            Setting::setValue($key, $value);
        }

        $products = [
            ['name' => 'Acoustic Panel 24x48', 'sku' => 'LA-ACP-2448', 'category' => 'acoustics', 'price' => 189.00, 'cost' => 78.00, 'stock_qty' => 64],
            ['name' => 'In-Ceiling Speaker Pair', 'sku' => 'LA-SPK-IC', 'category' => 'speakers', 'price' => 420.00, 'cost' => 210.00, 'stock_qty' => 28],
            ['name' => 'Atmos Height Module Pair', 'sku' => 'LA-SPK-ATM', 'category' => 'speakers', 'price' => 560.00, 'cost' => 290.00, 'stock_qty' => 16],
            ['name' => '12" Sealed Subwoofer', 'sku' => 'LA-SUB-12', 'category' => 'bass', 'price' => 899.00, 'cost' => 480.00, 'stock_qty' => 12],
            ['name' => '120" Tensioned Screen', 'sku' => 'LA-SCR-120', 'category' => 'projection', 'price' => 1890.00, 'cost' => 980.00, 'stock_qty' => 6],
            ['name' => 'Laser Projector Mount Kit', 'sku' => 'LA-PRJ-MNT', 'category' => 'projection', 'price' => 249.00, 'cost' => 95.00, 'stock_qty' => 18],
            ['name' => '22U Ventilated Media Rack', 'sku' => 'LA-RACK-22', 'category' => 'racks', 'price' => 740.00, 'cost' => 390.00, 'stock_qty' => 9],
            ['name' => 'CL2 Speaker Wire 500ft', 'sku' => 'LA-WIRE-CL2', 'category' => 'wiring', 'price' => 165.00, 'cost' => 72.00, 'stock_qty' => 40],
        ];
        foreach ($products as $product) {
            Product::query()->updateOrCreate(['sku' => $product['sku']], $product + [
                'description' => $product['name'].' — LumenArc inventory for Austin installs.',
                'is_active' => true,
                'unit' => 'each',
            ]);
        }

        $customers = [
            ['name' => 'Jordan Hale', 'email' => 'jordan@example.com', 'phone' => '(512) 555-2211', 'city' => 'Austin', 'state' => 'TX', 'zip' => '78704', 'address' => '2140 Barton Hills Dr'],
            ['name' => 'Priya Nair', 'email' => 'priya@example.com', 'phone' => '(512) 555-8832', 'city' => 'Round Rock', 'state' => 'TX', 'zip' => '78664', 'address' => '880 Palm Valley Blvd'],
            ['name' => 'Chris Delgado', 'email' => 'chris@example.com', 'phone' => '(512) 555-4410', 'city' => 'Westlake', 'state' => 'TX', 'zip' => '78746', 'address' => '310 Bee Cave Rd'],
            ['name' => 'Avery Kim', 'email' => 'avery@example.com', 'phone' => '(512) 555-7720', 'city' => 'Cedar Park', 'state' => 'TX', 'zip' => '78613', 'address' => '501 Cypress Creek Rd'],
        ];
        $customerModels = collect($customers)->map(fn ($c) => Customer::query()->updateOrCreate(['email' => $c['email']], $c));

        $jobDefs = [
            ['job_number' => 'LA-2401', 'title' => 'Dedicated theater — Barton Hills', 'status' => 'completed', 'estimated_value' => 48000, 'actual_value' => 51200],
            ['job_number' => 'LA-2402', 'title' => 'Surround + OLED wall — Round Rock', 'status' => 'in_progress', 'estimated_value' => 14500, 'actual_value' => 0],
            ['job_number' => 'LA-2403', 'title' => 'Projector & acoustic package — Westlake', 'status' => 'scheduled', 'estimated_value' => 28600, 'actual_value' => 0],
            ['job_number' => 'LA-2404', 'title' => 'Outdoor patio AV consult', 'status' => 'quoted', 'estimated_value' => 9800, 'actual_value' => 0],
            ['job_number' => 'LA-2405', 'title' => 'Media rack refresh — Cedar Park', 'status' => 'lead', 'estimated_value' => 4200, 'actual_value' => 0],
        ];

        $workOrders = collect($jobDefs)->map(function ($job, $i) use ($customerModels, $staff, $manager) {
            return WorkOrder::query()->updateOrCreate(
                ['job_number' => $job['job_number']],
                $job + [
                    'customer_id' => $customerModels[$i % $customerModels->count()]->id,
                    'assigned_to' => $i % 2 === 0 ? $staff->id : $manager->id,
                    'description' => 'Demo home theater / AV project for LumenArc ERP.',
                    'priority' => $i === 1 ? 'high' : 'normal',
                    'scheduled_start' => now()->subDays(10 - $i)->toDateString(),
                    'scheduled_end' => now()->subDays(8 - $i)->toDateString(),
                    'address' => $customerModels[$i % $customerModels->count()]->address.', '.$customerModels[$i % $customerModels->count()]->city,
                ]
            );
        });

        $invoice = Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-1001'],
            [
                'customer_id' => $customerModels[0]->id,
                'work_order_id' => $workOrders[0]->id,
                'issue_date' => now()->subDays(12)->toDateString(),
                'due_date' => now()->subDays(2)->toDateString(),
                'status' => 'paid',
                'subtotal' => 48000,
                'tax' => 3200,
                'total' => 51200,
                'amount_paid' => 51200,
                'notes' => 'Paid in full after calibration walkthrough.',
            ]
        );

        Payment::query()->updateOrCreate(
            ['reference' => 'PAY-1001'],
            [
                'invoice_id' => $invoice->id,
                'amount' => 51200,
                'method' => 'card',
                'paid_at' => now()->subDays(3)->toDateString(),
                'notes' => 'Final payment',
            ]
        );

        Invoice::query()->updateOrCreate(
            ['invoice_number' => 'INV-1002'],
            [
                'customer_id' => $customerModels[1]->id,
                'work_order_id' => $workOrders[1]->id,
                'issue_date' => now()->subDays(4)->toDateString(),
                'due_date' => now()->addDays(10)->toDateString(),
                'status' => 'sent',
                'subtotal' => 13200,
                'tax' => 1089,
                'total' => 14289,
                'amount_paid' => 3500,
                'notes' => 'Deposit received.',
            ]
        );

        Appointment::query()->updateOrCreate(
            ['title' => 'Acoustic survey — Westlake', 'starts_at' => now()->addDay()->setTime(8, 30)],
            [
                'customer_id' => $customerModels[2]->id,
                'work_order_id' => $workOrders[2]->id,
                'user_id' => $manager->id,
                'ends_at' => now()->addDay()->setTime(10, 0),
                'status' => 'confirmed',
                'location' => '310 Bee Cave Rd, Westlake',
                'notes' => 'Bring laser measure and SPL meter.',
            ]
        );

        Appointment::query()->updateOrCreate(
            ['title' => 'Surround install — Round Rock', 'starts_at' => now()->addDay()->setTime(11, 0)],
            [
                'customer_id' => $customerModels[1]->id,
                'work_order_id' => $workOrders[1]->id,
                'user_id' => $staff->id,
                'ends_at' => now()->addDay()->setTime(15, 0),
                'status' => 'scheduled',
                'location' => '880 Palm Valley Blvd, Round Rock',
            ]
        );

        $posts = [
            [
                'title' => 'How to Choose Between OLED and Projection for a Media Room',
                'excerpt' => 'Ambient light, screen size, and seating distance decide more than brand loyalty.',
                'cover_image' => 'https://images.unsplash.com/photo-1593784991095-a20506947072?auto=format&fit=crop&w=1200&q=80',
                'body' => "Austin living rooms often fight bright windows. OLED wins when ambient light is high and seating is close. Projection wins when you can control light and want 110\"+ cinema scale.\n\nLumenArc measures throw, seating rows, and light spill before recommending a path — then designs mounts, cable paths, and cooling around that choice.",
            ],
            [
                'title' => 'Bass Management Tips for Texas Slab Homes',
                'excerpt' => 'Concrete slabs and open plans create boom — here is how we tame it.',
                'cover_image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=1200&q=80',
                'body' => "Subwoofer placement matters more than wattage. We use multi-sub strategies, sealed designs when needed, and acoustic treatment so dialogue stays clear during action scenes.\n\nCalibration day includes room sweeps and family listening checks — not just a single mic position.",
            ],
            [
                'title' => 'Why a Clean Media Rack Saves Future Upgrades',
                'excerpt' => 'Labeled cable plants and service loops keep streaming boxes replaceable.',
                'cover_image' => 'https://images.unsplash.com/photo-1558002038-1055907df827?auto=format&fit=crop&w=1200&q=80',
                'body' => "Bird’s nests behind the TV kill future swaps. Ventilated racks, power conditioning, and documented patch bays mean a new streamer or AVR does not require drywall repair.\n\nEvery LumenArc install leaves a simple rack map for the homeowner.",
            ],
        ];
        foreach ($posts as $i => $post) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($post['title'])],
                $post + [
                    'is_published' => true,
                    'published_at' => now()->subDays(20 - $i * 4),
                    'author_id' => $admin->id,
                ]
            );
        }

        $articles = [
            [
                'title' => 'Prep Checklist Before Install Day',
                'category' => 'guides',
                'summary' => 'What homeowners should clear and confirm before the AV crew arrives.',
                'body' => "1. Clear furniture from install walls and seating rows.\n2. Confirm Wi-Fi SSID and password for streaming devices.\n3. Note existing cable paths and attic access.\n4. Confirm paint/touch-up plans if blackout fabric or panels are going in.\n5. Park vehicles clear of driveway staging.",
            ],
            [
                'title' => 'Common Issue: Dialogue Sounds Muddy',
                'category' => 'issues',
                'summary' => 'Usually speaker level mismatch or untreated first reflections.',
                'body' => "Muddy dialogue often means center channel level is low, surrounds are too hot, or untreated side walls smear speech. We rebalance levels, check speaker toe-in, and add absorption at first reflection points.",
            ],
            [
                'title' => 'Admin Manual: Creating a Job in Filament',
                'category' => 'admin',
                'summary' => 'Step-by-step for LumenArc staff using the ERP.',
                'body' => "1. Open Admin → Jobs → New.\n2. Assign customer and staff.\n3. Set status to Lead or Quoted.\n4. Add estimated value and address.\n5. Link appointments and invoices once approved.",
            ],
            [
                'title' => 'Troubleshooting: Invoice Balance Not Updating',
                'category' => 'troubleshooting',
                'summary' => 'Payments must be linked to the invoice record.',
                'body' => "Create a Payment against the invoice, then set amount_paid to match sum of payments. Status should move to Partial or Paid. If AI Studio is offline, demo replies still work without API keys.",
            ],
            [
                'title' => 'Guide: Planning a Dedicated Theater Layout',
                'category' => 'guides',
                'summary' => 'Sightlines, risers, speaker height, and rack location.',
                'body' => "Start with seating distance and screen height so the first row does not crane necks. Plan risers for second-row sightlines, keep speaker height consistent, and place the rack where ventilation and service access are easy — never buried behind drywall without access panels.",
            ],
        ];
        foreach ($articles as $i => $article) {
            KnowledgeArticle::query()->updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                $article + [
                    'sort_order' => $i + 1,
                    'is_published' => true,
                ]
            );
        }
    }
}
