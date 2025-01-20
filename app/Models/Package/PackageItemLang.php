<?php

namespace App\Models\Package;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\Package\PackageItemLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PackageItemLang whereTitle($value)
 * @mixin \Eloquent
 */
class PackageItemLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = "package_items_lang";
}
