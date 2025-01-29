<?php

namespace App\Models\Service;

use App\Filament\Helpers\Translatable;
use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Models\Company\CompanyLang;
use App\Models\Slider\Slider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Service\Service
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $image_id
 * @property int|null $promote_to_homepage
 * @property float|null $price
 * @property string|null $slug
 * @property string $view_type
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \Awcodes\Curator\Models\Media|null $cover_image
 * @property-read \Awcodes\Curator\Models\Media|null $image
 * @property-read \App\Models\Service\ServiceLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Service\ServiceLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Service active()
 * @method static \Illuminate\Database\Eloquent\Builder|Service listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Service translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePromoteToHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereViewType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service withTranslation(?string $locale = null)
 * @property int $has_form
 * @property int|null $slider_id
 * @property int $one_time_payment
 * @property-read Slider|null $slider
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereHasForm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereOneTimePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereSliderId($value)
 * @property int $paid
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePaid($value)
 * @mixin \Eloquent
 */
class Service extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, Translatable, Auditable, HasStatus, \App\Helpers\HasTranslations, HasMedia, ApiResponse, HasTimestamps, HasSlug;

    public const VIEW_TYPE_1 = "view-1";
    public const VIEW_TYPE_2 = "view-2";
    public const VIEW_TYPE_3 = "view-3";

    public static function getViewTypes(){
        return [
            self::VIEW_TYPE_1 => __("Normal"),
            self::VIEW_TYPE_2 => __("Consultation Form"),
            self::VIEW_TYPE_3 => __("Indicator"),
        ];
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public $translationModel = ServiceLang::class;
    public array $translatedAttributes = [
        'title', 'description', 'content', 'youtube_video_id'
    ];

    public array $upload_attributes = [
        'image_id'
    ];

    public function slider(){
        return $this->hasOne(Slider::class, 'id', 'slider_id');
    }
}
