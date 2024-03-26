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

    public string $search = '';
    public string $trashed = '';
    public string $plan = '';

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'trashed' => ['except' => ''],
        'plan' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        sleep(2);
        $tenantService = new TenantService();
        $planService = new PlanService();
        $filters = [
            'search' => $this->search,
            'trashed' => $this->trashed,
            'plan' => $this->plan
        ];
        return view('livewire.tenants.table', [
            'plans' => $planService->toSelect(),
            'tenants' => $tenantService->index($filters),
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
        $this->trashed = '';
        $this->plan = '';
        $this->emit('resetSelectpicker');
    }
}
