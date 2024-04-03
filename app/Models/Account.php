<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'revenue_expense_id',
        'provider_id',
        'user_id',
        'qty',
        'total',
        'description'
    ];

    public function scopeFilter($query, array $filters): void
    {
//        $query->when($filters['search'] ?? null, function ($query, $search) {
//            $query->where('name', 'LIKE', '%' . $search . '%');
//        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
//            if ($trashed === 'only') {
//                $query->onlyTrashed();
//            }
//        });
        $query->when(!($filters['date_start'] && $filters['date_end']), function ($query) use ($filters) {
            $query->whereHas('parcels', function ($query) {
                $query->whereMonth('due_date', Carbon::now()->month);
            });
        }, function ($query) use ($filters) {
            $query->whereHas('parcels', function ($query) use ($filters) {
                $query->whereBetween('due_date', [$filters['date_start'], $filters['date_end']]);
            });
        });
    }

    public function scopeWhereTenantId($query) {
        return $query->where("tenant_id", auth()->user()->tenant->id);
    }

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function parcels(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AccountParcel::class)->where('tenant_id', auth()->user()->tenant->id);
    }

    public function revenueExpense(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(RevenueExpense::class);
    }

    public function provider(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
