<?php

namespace App\Models\PaymentGateway;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\PaymentGateway\PaymentGatewayLang
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $content
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang query()
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PaymentGatewayLang whereTitle($value)
 * @mixin \Eloquent
 */
class PaymentGatewayLang extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $table = "payment_gateways_lang";
}