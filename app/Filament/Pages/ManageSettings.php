<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationLabel = 'Settings';

    protected static ?string $title = 'Company Settings';

    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'company_name' => Setting::getValue('company_name', 'LumenArc Home Cinema'),
            'phone' => Setting::getValue('phone', '(512) 555-0194'),
            'email' => Setting::getValue('email', 'hello@lumenarchomecinema.com'),
            'address' => Setting::getValue('address', '3801 S Lamar Blvd, Austin, TX 78704'),
            'whatsapp' => Setting::getValue('whatsapp', '15125550194'),
            'tagline' => Setting::getValue('tagline', 'Custom home theaters & AV for Texas living'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('company_name')->required(),
                TextInput::make('tagline'),
                TextInput::make('phone'),
                TextInput::make('email')->email(),
                TextInput::make('whatsapp')->label('WhatsApp number (digits)'),
                Textarea::make('address')->rows(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::setValue($key, $value);
        }

        Notification::make()->title('Settings saved')->success()->send();
    }
}
