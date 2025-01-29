<?php

namespace App\Filament\Admin\Pages;

use App\Exports\SiteSettingsExport;
use App\Filament\Components\FileUpload;
use App\Filament\Components\RichEditor;
use App\Filament\Components\TextInput;
use App\Filament\Components\TinyEditor;
use App\Filament\Components\TiptapEditor;
use App\Settings\Site;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use CactusGalaxy\FilamentAstrotomic\Forms\Components\TranslatableTabs;
use CactusGalaxy\FilamentAstrotomic\TranslatableTab;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Illuminate\Contracts\Support\Htmlable;
use Tiptap\Nodes\Text;

class ManageSiteSettings extends SettingsPage
{
    use HasPageShield;
    protected static ?string $navigationGroup = "Site Settings";

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = Site::class;

    public function getTitle(): string|Htmlable
    {
        return __("Site Settings");
    }

    public static function getNavigationLabel(): string
    {
        return __("Site Settings");
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('Export')
                ->label(__("Export"))
                ->action(function(){
                    return \Maatwebsite\Excel\Facades\Excel::download(new SiteSettingsExport, 'site-settings.xlsx');
                })

        ];
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        foreach (config('app.locales') as $locale => $language){
            $tabs[] = Forms\Components\Tabs\Tab::make($language)->schema([
                Forms\Components\Grid::make()
                    ->columns(3)
                    ->schema([
                        FileUpload::make("fav_icon")
                            ->multiple(false)
                            ->label(__("Fav Icon")),
                        FileUpload::make("logo")
                            ->multiple(false)
                            ->label(__("Logo")),
                        TinyEditor::make("footer_description.{$locale}")
                            ->showMenuBar()
                            ->label(__("Footer Description"))
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Grid::make()
                    ->columns(1)
                    ->schema([
                        TextInput::make("email")
                            ->label(__("Email"))
                            ->email(),
                        TextInput::make("phone")
                            ->label(__("Phone")),
                    ])
            ]);
        }
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\Tabs::make()
                                        ->tabs($tabs)
                                        ->columnSpanFull(),
                                ])
                                ->columnSpan(1),
                            Forms\Components\Grid::make()
                                ->schema([
                                    Forms\Components\Section::make()
                                        ->schema([
                                            TextInput::make('facebook_link')
                                                ->label(__("Facebook")),
                                            TextInput::make('instagram_link')
                                                ->label(__("Instagram")),
                                            TextInput::make('twitter_link')
                                                ->label(__("Twitter")),
                                            TextInput::make('linkedin_link')
                                                ->label(__("Linkedin")),
                                            TextInput::make('youtube_link')
                                                ->label(__("Youtube")),
                                            TextInput::make("contact_us_whatsapp_number")
                                                ->label(__("Contact Us Whatsapp Number"))
                                                ->required(),
                                            TextInput::make('telegram_link')
                                                ->label(__("Telegram")),
                                        ]),
                                    Forms\Components\Section::make()
                                        ->heading(__("SMTP Settings"))
                                        ->schema([
                                            Forms\Components\Grid::make(3)->schema([
                                                TextInput::make('smtp_server')
                                                    ->label(__("Server"))
                                                    ->required(),
                                                TextInput::make('smtp_port')
                                                    ->label(__("Port"))
                                                    ->required(),
                                                TextInput::make('smtp_encryption')
                                                    ->label(__("Encryption"))
                                                    ->required(),
                                                Forms\Components\Grid::make()->schema([
                                                    TextInput::make('smtp_username')
                                                        ->label(__("Username"))
                                                        ->required(),
                                                    TextInput::make('smtp_password')
                                                        ->label(__("Password"))
                                                        ->required(),
                                                    TextInput::make("smtp_from_address")
                                                        ->label(__("From Address"))
                                                        ->required(),
                                                    TextInput::make('smtp_from_name')
                                                        ->label(__("From Name"))
                                                        ->required(),
                                                ])
                                            ])
                                        ]),
                                    Forms\Components\Section::make()
                                        ->heading(__("PAYPAL Settings"))
                                        ->schema([
                                            Forms\Components\Grid::make(1)->schema([
                                                Forms\Components\Toggle::make('paypal_mode')
                                                    ->label(__("Live")),
                                                TextInput::make('paypal_client_id')
                                                    ->label(__("Client ID"))
                                                    ->required(),
                                                TextInput::make('paypal_client_secret')
                                                    ->label(__("Client Secret"))
                                                    ->required(),
                                                TextInput::make('paypal_app_id')
                                                    ->label(__("App ID"))
                                                    ->required(),
                                            ])
                                        ]),
                                    Forms\Components\Section::make()
                                        ->schema([
                                            TextInput::make('promo_code')
                                                ->label(__("Promo Code"))
                                        ])
                                        ->columnSpanFull()
                                ])->columnSpan(1),
                        ])
                        ->columnSpanFull(),
                ])
            ]);
    }
}
