<?php

namespace App\Livewire\Account;

use App\Models\Account;
use App\Models\AccountParcel;
use App\Models\RevenueExpense;
use App\Services\AccountService;
use App\Services\RevenueExpenseService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $trashed = '';
    public $revenue_expense = '';
    public $date_start = '';
    public $date_end = '';

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'trashed' => ['except' => ''],
        'revenue_expense' => ['except' => ''],
    ];

    public function mount()
    {
        $this->date_start = now()->startOfMonth()->toDateString();
        $this->date_end = now()->endOfMonth()->toDateString();
    }

    public function render()
    {
        $accounts = new AccountService();
        $revenues = new RevenueExpenseService();
        $filters = [
            'trashed' => $this->trashed,
            'revenue_expense' => $this->revenue_expense,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ];

        return view('livewire.account.table', [
            'data' => $accounts->index($filters),
            'revenues' => $revenues->toSelect(),
            'totalMonth' => $accounts->totalMonth($this->revenue_expense, $this->date_start, $this->date_end),
            'totalPaid' => $accounts->totalPaid($this->revenue_expense, $this->date_start, $this->date_end),
            'totalArrears' => $accounts->totalArrears($this->revenue_expense),
            'totalCommission' => $accounts->totalCommission($this->date_start, $this->date_end),
            'balance' => $accounts->balance($this->revenue_expense, $this->date_start, $this->date_end)
        ]);
    }

    public function clearFilter(): void
    {
        $this->trashed = '';
        $this->revenue_expense = [];
        $this->date_start = now()->firstOfMonth()->format('Y-m-d');;
        $this->date_end = now()->lastOfMonth()->format('Y-m-d');
        $this->emit('resetSelectpicker');
    }

}
