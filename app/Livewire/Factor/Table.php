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

    public string $operator = '';
    public string $type = '';
    public string $trashed = '';

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'operator' => ['except' => ''],
        'type' => ['except' => ''],
        'trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $factors = new FactorService();
        $operators = new OperatorService();
        $types = new OrderTypeService();

        $filters = [
            'operator' => $this->operator,
            'type' => $this->type,
            'trashed' => $this->trashed
        ];
        return view('livewire.factor.table', [
            'data' => $factors->index($filters),
            'operators' => $operators->toSelect(),
            'types' => $types->toSelect()
        ]);
    }

    public function clearFilter(): void
    {
        $this->operator = '';
        $this->type = '';
        $this->trashed = '';
        $this->emit('resetSelectpicker');
    }
}
