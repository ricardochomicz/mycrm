<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'category_id',
        'operator_id',
        'name',
        'price',
        'slug',
        'description',
        'image',
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function operator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Operator::class);
    }

    public function scopeFilter($query, array $filters): void
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        })->when($filters['operator'] ?? null, function ($query, $operator) {
            $query->where('operator_id', $operator);
        })->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('category_id', $category);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => mb_strtoupper($value, 'UTF-8'),
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => number_format($value, 2, ',', '.'),
            set: fn(string $value) => floatval(str_replace(',', '.', str_replace('.', '', $value)))
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    function getImageUrlAttribute(): string
    {
        if ($this->image == '') {
            return Storage::url(config('app.cdn_storage') . '/avatar/avatar.png');
        }
        return Storage::url($this->image);
    }

}
