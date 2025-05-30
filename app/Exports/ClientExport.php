<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class ClientExport extends BaseExport
{
    protected array $exclude = [
        'weight', 'slug', 'status', 'promote',
        'image', 'inner_image', 'id', 'features',
        'link', 'buttons', 'bullets', 'form_type',
        'validations', 'category', 'url', 'promote_to_homepage',
        'is_video', 'video_url', 'slider', 'heading_news',
        'active', 'fcm_token', 'mobile_type', 'notification', 'verified'
    ];
}
