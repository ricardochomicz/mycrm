<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class RoleService
{
    public function toSelect($data = [])
    {
        if (Gate::allows('isSuperAdmin', auth()->user())) {
            return Role::orderBy('name')->get(['id', 'label as name']);
        } else {
            return Role::whereIn('id', [2, 3, 4, 5])
                ->orderBy('name')->get(['id', 'label as name']);
        }

    }
}