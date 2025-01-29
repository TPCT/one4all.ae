<?php

namespace App\Models\PaymentGateway;

use App\Filament\Helpers\Translatable;
use App\Helpers\HasAuthor;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\PaymentGateway\PaymentGateway
 *
 * @property int $id
 * @property int $admin_id
 * @property int|null $image_id
 * @property string $slug
 * @property int $status
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \App\Models\PaymentGateway\PaymentGatewayLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PaymentGateway\PaymentGatewayLang> $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway active()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway translated()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGateway withTranslation(?string $locale = null)
 * @mixin \Eloquent
 */
class PaymentGateway extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Translatable, HasAuthor, Auditable, HasStatus, \App\Helpers\HasTranslations, HasSlug;

    public $translationModel = PaymentGatewayLang::class;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public array $translatedAttributes = [
        'title',
        'content',
    ];

    public array $upload_attributes = [];
}