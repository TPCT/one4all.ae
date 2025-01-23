<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $image_id
 * @property string $title
 * @property string $code
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @method static \Illuminate\Database\Eloquent\Builder|Currency active()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Currency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Currency extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable, HasAuthor, HasTimestamps, HasStatus;

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
