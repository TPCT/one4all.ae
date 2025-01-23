<?php

namespace App\Models\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Service\ServiceLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property string $content
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereTitle($value)
 * @property string|null $youtube_video_id
 * @method static \Illuminate\Database\Eloquent\Builder|ServiceLang whereYoutubeVideoId($value)
 * @mixin \Eloquent
 */
class ServiceLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = "services_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}