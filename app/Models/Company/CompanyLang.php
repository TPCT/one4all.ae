<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Company\CompanyLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyLang whereTitle($value)
 * @mixin \Eloquent
 */
class CompanyLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $table = "companies_lang";
    public $timestamps = false;
    protected $guarded = [
        'id'
    ];
}