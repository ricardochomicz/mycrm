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
            'totalMonth' => $this->totalMonth(),
            'totalPaid' => $this->totalPaid(),
            'totalArrears' => $this->totalArrears(),
            'totalCommission' => $this->totalCommission(),
            'balance' => $this->balance()
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

    public function totalMonth()
    {
        return AccountParcel::whereHas('account', function ($query) {
            $query->whereNotIn('revenue_expense_id', [1, 2, 3])
                ->where(['tenant_id' => auth()->user()->tenant->id]);
                 if (!empty($this->revenue_expense)) {
                     $query->whereIn('revenue_expense_id', $this->revenue_expense);
                 }
        })
            ->whereBetween('due_date', [$this->date_start, $this->date_end])->sum('value');
    }

//    public function totalDay()
//    {
//        return AccountParcel::whereHas('account', function ($query) {
//            $query->whereNotIn('revenue_expense_id', [1, 2, 3])
//                ->whereBetween('due_date', [$this->date_start, $this->date_end]);
//        })->where(['tenant_id' => auth()->user()->tenant->id, 'payment_status' => 0])
//            ->whereDate('due_date', Carbon::now()->toDateString())->sum('value');
//    }

    public function totalArrears()
    {
        return AccountParcel::whereHas('account', function ($query) {
            $query->whereNotIn('revenue_expense_id', [1, 2, 3])
                ->where(['tenant_id' => auth()->user()->tenant->id, 'payment_status' => 0]);
                 if (!empty($this->revenue_expense)) {
                     $query->whereIn('revenue_expense_id', $this->revenue_expense);
                 }

        })->whereDate('due_date', '<', Carbon::now()->toDateString())->sum('value');
    }

    public function totalPaid()
    {
        return AccountParcel::whereHas('account', function ($query) {
            $query->whereNotIn('revenue_expense_id', [1, 2, 3])
                ->whereBetween('payment', [$this->date_start, $this->date_end]);
            if (!empty($this->revenue_expense)) {
                $query->whereIn('revenue_expense_id', $this->revenue_expense);
            }
        })->where(['tenant_id' => auth()->user()->tenant->id, 'payment_status' => 1])->sum('value');
//            ->whereMonth('payment', Carbon::now()->month)->sum('value');
    }

    public function totalCommission()
    {
        return AccountParcel::whereHas('account', function ($query) {
            $query->whereIn('revenue_expense_id', [1, 2, 3])
                ->whereBetween('due_date', [$this->date_start, $this->date_end]);
        })
            ->where(['tenant_id' => auth()->user()->tenant->id])
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('value');
    }

    public function balance()
    {
        return $this->totalCommission() - $this->totalPaid();
    }
}
