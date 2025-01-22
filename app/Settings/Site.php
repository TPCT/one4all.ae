<?php

namespace App\Settings;

use App\Helpers\TranslatableSettings;
use Spatie\LaravelSettings\Settings;

class Site extends Settings
{
    private array $translatable = [
        'fav_icon', 'logo', 'mobile_logo', 'footer_logo', 'address', 'footer_description', 'p_o_box'
    ];

    private array $uploads = [
        'fav_icon', 'logo', 'mobile_logo', 'footer_logo'
    ];

    public function translatable()
    {
        return $this->translatable;
    }

    public function uploads(){
        return $this->uploads;
    }

    use TranslatableSettings;

    public ?string $fav_icon;
    public ?string $logo;
    public ?array $footer_description;

    public ?string $email;
    public ?string $phone;
    public ?string $contact_us_whatsapp_number;

    public ?string $facebook_link;
    public ?string $instagram_link;
    public ?string $twitter_link;
    public ?string $linkedin_link;
    public ?string $telegram_link;
    public ?string $youtube_link;
    public ?string $promo_code;
    public ?string $smtp_server;
    public ?string $smtp_port;
    public ?string $smtp_encryption;
    public ?string $smtp_username;
    public ?string $smtp_password;
    public ?string $smtp_from_address;
    public ?string $smtp_from_name;

    public ?string $paypal_mode;
    public ?string $paypal_client_id;
    public ?string $paypal_client_secret;
    public ?string $paypal_app_id;

    public ?int $default_page_size;
    public ?string $contact_us_mailing_list;

    public static function group(): string
    {
        return 'site';
    }
}
