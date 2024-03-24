<?php

namespace App\Livewire\Factor;

use App\Services\FactorService;
use App\Services\OperatorService;
use App\Services\OrderTypeService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public array $filters = ['operator', 'type', 'trashed'];

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected array $queryString = [
        'filters.operator' => ['except' => ''],
        'filters.type' => ['except' => ''],
        'filters.trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $factors = new FactorService();
        $operators = new OperatorService();
        $types = new OrderTypeService();
        return view('livewire.factor.table', [
            'data' => $factors->index($this->filters),
            'operators' => $operators->toSelect(),
            'types' => $types->toSelect()
        ]);
    }

    public function clearFilter(): void
    {
        $this->filters = [];
        $this->dispatch('resetSelectpicker');
    }
}
