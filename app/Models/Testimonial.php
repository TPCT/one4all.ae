<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Testimonial  extends Model implements Auditable
{
    use HasFactory, HasAuthor, HasStatus, HasTimestamps, HasMedia, \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $upload_attributes = [
        'image_id'
    ];
}

