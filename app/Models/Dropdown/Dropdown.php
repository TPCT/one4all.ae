<?php

namespace App\Models\Dropdown;

use App\Helpers\ApiResponse;
use App\Helpers\HasAuthor;
use App\Helpers\HasMedia;
use App\Helpers\HasSlug;
use App\Helpers\HasStatus;
use App\Helpers\HasUploads;
use App\Models\Block\Block;
use App\Filament\Helpers\Translatable;
use App\Models\TeamMember\TeamMember;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Dropdown\Dropdown
 *
 * @property int $id
 * @property int $user_id
 * @property string $slug
 * @property string $category
 * @property int $status
 * @property string $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property array|null $validations
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\Admin $author
 * @property-read \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection<int, Block> $blocks
 * @property-read int|null $blocks_count
 * @property-read \Awcodes\Curator\Models\Media|null $image
 * @property-read \App\Models\Dropdown\DropdownLang|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Dropdown\DropdownLang> $translations
 * @property-read int|null $translations_count
 * @property-read \App\Models\Admin $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, TeamMember> $team_members
 * @property-read int|null $team_members_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown active()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown translations()
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereValidations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown withTranslation(?string $locale = null)
 * @property int $admin_id
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereAdminId($value)
 * @property-read \Awcodes\Curator\Models\Media|null $cover_image
 * @property string|null $account_type
 * @property int|null $lout_amount
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dropdown whereLoutAmount($value)
 * @mixin \Eloquent
 */
class Dropdown extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasAuthor, Translatable, Auditable, HasStatus, \App\Helpers\HasTranslations, HasMedia, HasSlug, ApiResponse;


    public const BLOCK_CATEGORY = "Block Category";
    public const CONSULTATION_CATEGORY = "Consultation Category";
    public const CASHBACK_CATEGORY = "Cashback Category";

    public const ACCOUNT_TYPE_1 = "ACCOUNT_TYPE_1";
    public const ACCOUNT_TYPE_2 = "ACCOUNT_TYPE_2";

    public static function getAccountTypes(){
        return [
            self::ACCOUNT_TYPE_1 => __("site." . self::ACCOUNT_TYPE_1),
            self::ACCOUNT_TYPE_2 => __("site." . self::ACCOUNT_TYPE_2),
        ];
    }

    public static function getCategories(): array
    {
        return [
            self::BLOCK_CATEGORY => __(self::BLOCK_CATEGORY),
            self::CONSULTATION_CATEGORY => __(self::CONSULTATION_CATEGORY),
            self::CASHBACK_CATEGORY => __(self::CASHBACK_CATEGORY),
        ];
    }

    protected $guarded = ['id', 'created_at', 'updated_at'];


    public $translationModel = DropdownLang::class;
    public array $translatedAttributes = [
        'title', 'description', 'image_id', 'second_title'
    ];

    protected $casts = [
        'validations' => 'array'
    ];

    public array $upload_attributes = [
        'image_id'
    ];

    public function blocks(){
        return $this
            ->hasMany(Block::class, 'dropdown_id', 'id')
            ->where('dropdown_id', $this->id);
    }

    public function team_members(){
        return $this
            ->hasMany(TeamMember::class, 'dropdown_id', 'id')
            ->where('dropdown_id', $this->id);
    }
}
