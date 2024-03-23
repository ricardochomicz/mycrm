<?php

namespace App\Observers;

use App\Models\Plan;
use Illuminate\Support\Str;

class PlanObserver
{
    public function creating(Plan $plan): void
    {
        $plan->slug = Str::slug($plan->name);
    }

    public function updating(Plan $plan): void
    {
        $plan->slug = Str::slug($plan->name);
    }
}
