<?php

namespace App\Livewire\RevenueExpense;

use App\Services\RevenueExpenseService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $trashed = '';

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'trashed' => ['except' => ''],
    ];

    public function render()
    {
        $revenues = new RevenueExpenseService();
        $filters = [
            'search' => $this->search,
            'trashed' => $this->trashed
        ];

        return view('livewire.revenue-expense.table',[
            'data' => $revenues->index($filters)
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
        $this->trashed = '';
        $this->emit('resetSelectpicker');
    }
}
