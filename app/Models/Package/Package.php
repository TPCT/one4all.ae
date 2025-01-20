<?php

namespace App\Models\Package;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasSection;
use App\Helpers\HasServices;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Models\Service\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Package\Package
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $price
 * @property string $slug
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $months
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read array|null $service_ids
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Package\PackageItem> $items
 * @property-read int|null $items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Service> $services
 * @property-read int|null $services_count
 * @property-read \App\Models\Package\PackageLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Package\PackageLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Package active()
 * @method static \Illuminate\Database\Eloquent\Builder|Package listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Package translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class Package extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Translatable, HasAuthor, Auditable, HasStatus, HasServices, \App\Helpers\HasTranslations, HasSlug;

    public $translationModel = PackageLang::class;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = [
        'title',
        'discount',
        'description',
    ];

    public array $upload_attributes = [];

    public function items(){
        return $this->hasMany(PackageItem::class);
    }
}
