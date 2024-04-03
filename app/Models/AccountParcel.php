<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountParcel extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'payment_interest' => 'decimal:2',
    ];

    protected $fillable = [
        'tenant_id',
        'account_id',
        'user_id',
        'number_parcel',
        'value',
        'due_date',
        'payment',
        'payment_status',
        'payment_interest'
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function account(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

//    protected function dueDate(): Attribute
//    {
//        return Attribute::make(
//            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
//        );
//    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['revenue_expense'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('account', function ($query) use ($search) {
                    $query->whereIn('revenue_expense_id', $search);
                });
            });
        });
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
        $query->when(!($filters['date_start'] && $filters['date_end']), function ($query) use ($filters) {
            $query->whereMonth('due_date', Carbon::now()->month);
        }, function ($query) use ($filters) {
            $query->whereBetween('due_date', [$filters['date_start'], $filters['date_end']]);
        });
    }

    protected function value(): Attribute
    {
        return Attribute::make(
//            get: fn(?string $value) => (int)$value ? number_format($value, 2, ',', '.') : null,
            set: fn(?string $value) => floatval(str_replace(',', '.', str_replace('.', '', $value)))
        );
    }

    protected function paymentInterest(): Attribute
    {
        return Attribute::make(
//            get: fn(?string $value) => is_numeric($value) ? number_format($value, 2, ',', '.') : null,
            set: fn(?string $value) => floatval(str_replace(',', '.', str_replace('.', '', $value)))
        );
    }

    public function getTotalAttribute(): float
    {
        $value = (float) str_replace(',', '.', $this->value ?? 0);
        $interest = (float) str_replace(',', '.', $this->payment_interest ?? 0);
        return $value +  $interest;
    }


}
