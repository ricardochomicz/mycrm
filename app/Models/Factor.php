<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'factor',
        'tenant_id',
        'operator_id',
        'ordertype_id'
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function operator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function ordertype(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderType::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['operator'] ?? null, function ($query, $operator) {
            $query->where('operator_id', $operator);
        })->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('ordertype_id', $type);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }
}
