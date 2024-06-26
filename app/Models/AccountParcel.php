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
        'amount_paid',
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
//        $query->when($filters['revenue_expense'] ?? null, function ($query, $search) use ($filters) {
//            $query->whereHas('account', function ($query) use ($search) {
//                $query->whereIn('revenue_expense_id', $search);
//            })->where(function ($query) {
//                $query->where('due_date', '<', Carbon::now()->toDateString())
//                    ->orWhereNull('due_date');
//            });
//        });
//
//        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
//            if ($trashed === 'only') {
//                $query->onlyTrashed();
//            }
//            if ($trashed === 'arrears') {
//                $query->where('payment_status', 0)
//                    ->where(function ($query) {
//                        $query->where('due_date', '<', Carbon::now()->toDateString())
//                            ->orWhereNull('due_date');
//                    });
//            }
//        });
//
//        if ($filters['trashed'] === 'arrears') {
//            $query->where('payment_status', 0)
//                ->where(function ($query) {
//                    $query->where('due_date', '<', Carbon::now()->toDateString())
//                        ->orWhereNull('due_date');
//                });
//        } else {
//            $query->when(!($filters['trashed'] || $filters['revenue_expense'] || $filters['date_start'] && $filters['date_end']), function ($query) use ($filters) {
//                $query->whereMonth('due_date', Carbon::now()->month);
//            }, function ($query) use ($filters) {
//                $query->whereBetween('due_date', [$filters['date_start'], $filters['date_end']]);
//            });
//        }
        if ($filters['trashed'] === 'arrears') {
            $query->where('payment_status', 0)
                ->where(function ($query) {
                    $query->where('due_date', '<', Carbon::now()->toDateString())
                        ->orWhereNull('due_date');
                });
        } elseif ($filters['revenue_expense'] ?? null) {
            $query->whereHas('account', function ($query) use ($filters) {
                $query->whereIn('revenue_expense_id', $filters['revenue_expense']);
            })->where(function ($query) {
                $query->where('due_date', '<=', Carbon::now()->toDateString())
                    ->orWhere('due_date', '>=', Carbon::now()->toDateString());
            });
        } else {
            $query->when(!($filters['trashed'] || $filters['revenue_expense'] || $filters['date_start'] && $filters['date_end']), function ($query) use ($filters) {
                $query->whereMonth('due_date', Carbon::now()->month);
            }, function ($query) use ($filters) {
                $query->whereBetween('due_date', [$filters['date_start'], $filters['date_end']]);
            });
        }
    }


    protected function value(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => floatval(str_replace(',', '.', str_replace('.', '', $value)))
        );
    }

    protected function amountPaid(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => floatval(str_replace(',', '.', str_replace('.', '', $value)))
        );
    }

    protected function paymentInterest(): Attribute
    {
        return Attribute::make(
            set: fn(?string $value) => floatval(str_replace(',', '.', str_replace('.', '', $value)))
        );
    }

    public function getTotalAttribute(): float
    {
        $value = (float)str_replace(',', '.', $this->value ?? 0);
        $interest = (float)str_replace(',', '.', $this->payment_interest ?? 0);
        return $value + $interest;
    }


}
