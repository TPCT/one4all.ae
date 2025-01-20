<?php

namespace App\Models\Package;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasSection;
use App\Helpers\HasStatus;
use App\Helpers\HasTimestamps;
use App\Models\Block\BlockFeature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

/**
 * App\Models\Package\PackageItem
 *
 * @property int $id
 * @property int $admin_id
 * @property int $package_id
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \App\Models\Package\Package $package
 * @property-read \App\Models\Package\PackageItemLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Package\PackageItemLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem active()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem translated()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItem withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class PackageItem extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Translatable, HasAuthor, Auditable, HasStatus, HasTimestamps, \App\Helpers\HasTranslations;

    public $translationModel = PackageItemLang::class;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = [
        'title'
    ];

    public array $upload_attributes = [];

    public function package(){
        return $this->belongsTo(Package::class);
    }
}