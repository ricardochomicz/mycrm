<?php

namespace App\Observers;

use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantObserver
{
    public function creating(Tenant $tenant)
    {
        $tenant->uuid = Str::uuid();
        $tenant->slug = Str::slug($tenant->name);
    }

    public function updating(Tenant $tenant)
    {
        $tenant->slug = Str::slug($tenant->name);
    }
}
