<?php

namespace App\Exports;

use App\Helpers\BaseExport;

class BoothVoucherExport extends BaseExport
{
    protected array $translatable = [
        'title', 'branch'
    ];

    protected array $exclude = [
        'weight', 'slug', 'status', 'promote',
        'image', 'inner_image', 'id', 'features',
        'link', 'buttons', 'bullets', 'form_type',
        'validations', 'category', 'url', 'promote_to_homepage',
        'is_video', 'video_url', 'slider', 'heading_news', 'active',
        'uuid'
    ];
}
