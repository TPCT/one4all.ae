<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;

/**
 * App\Models\ClientConsultation
 *
 * @property int $id
 * @property int $dropdown_id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $whatsapp
 * @property string|null $date
 * @property string|null $time
 * @property string|null $notes
 * @property int $paid
 * @property int $done
 * @property string|null $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \OwenIt\Auditing\Models\Audit> $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereDropdownId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientConsultation whereWhatsapp($value)
 * @mixin \Eloquent
 */
class ClientConsultation extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable;

    protected $table = 'client_consultations';

    protected $guarded = ['id', 'created_at', 'updated_at'];
}