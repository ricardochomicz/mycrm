<?php

namespace App\Livewire\Tenants;

use App\Models\Tenant;
use App\Services\PlanService;
use App\Services\TenantService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';


    public array $filters = ['search', 'trashed', 'plan'];

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'filters.search' => ['except' => ''],
        'filters.trashed' => ['except' => ''],
        'filters.plan' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $tenantService = new TenantService();
        $planService = new PlanService();
        return view('livewire.tenants.table', [
            'plans' => $planService->toSelect(),
            'tenants' => $tenantService->index($this->filters),
        ]);
    }

    public function clearFilter(): void
    {
        $this->filters = [];
        $this->dispatch('resetSelectpicker');
    }
}
