<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * App\Models\Testimonial
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $image_id
 * @property string $name
 * @property string $position
 * @property string $description
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \Awcodes\Curator\Models\Media|null $cover_image
 * @property-read \Awcodes\Curator\Models\Media|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial active()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Testimonial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonial  extends Model implements Auditable
{
    use HasFactory, HasAuthor, HasStatus, HasTimestamps, HasMedia, \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $upload_attributes = [
        'image_id'
    ];
}

