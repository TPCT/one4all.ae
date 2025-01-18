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

    public ?string $facebook_link;
    public ?string $instagram_link;
    public ?string $twitter_link;
    public ?string $linkedin_link;
    public ?string $youtube_link;
    public ?int $default_page_size;
    public ?string $contact_us_mailing_list;

    public static function group(): string
    {
        return 'site';
    }
}
