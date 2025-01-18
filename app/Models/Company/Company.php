<?php

namespace App\Models\Company;

use App\Filament\Helpers\Translatable;
use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Models\Dropdown\DropdownLang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Company\Company
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $image_id
 * @property string|null $url
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \Awcodes\Curator\Models\Media|null $cover_image
 * @property-read \Awcodes\Curator\Models\Media|null $image
 * @property-read \App\Models\Company\CompanyLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Company\CompanyLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Company active()
 * @method static \Illuminate\Database\Eloquent\Builder|Company listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Company orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Company orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Company orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Company translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class Company extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, Translatable, Auditable, HasStatus, \App\Helpers\HasTranslations, HasMedia, ApiResponse, HasTimestamps;

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public $translationModel = CompanyLang::class;
    public array $translatedAttributes = [
        'title', 'description'
    ];

    public array $upload_attributes = [
        'image_id'
    ];
}
