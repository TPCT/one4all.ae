<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Package\PackageLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string|null $discount
 * @property string $description
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageLang whereTitle($value)
 * @mixin \Eloquent
 */
class PackageLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = "packages_lang";
}
