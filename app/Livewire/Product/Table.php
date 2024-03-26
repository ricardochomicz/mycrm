<?php

namespace App\Livewire\Product;

use App\Services\CategoryService;
use App\Services\OperatorService;
use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $trashed = '';
    public string $operator = '';
    public string $category = '';

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'operator' => ['except' => ''],
        'category' => ['except' => ''],
        'trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $products = new ProductService();
        $operators = new OperatorService();
        $categories = new CategoryService();
        $filters = [
            'search' => $this->search,
            'trashed' => $this->trashed,
            'operator' => $this->operator,
            'category' => $this->category,
        ];
        return view('livewire.product.table', [
            'data' => $products->index($filters),
            'operators' => $operators->toSelect(),
            'categories' => $categories->toSelect()
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
        $this->trashed = '';
        $this->operator = '';
        $this->category = '';
        $this->emit('resetSelectpicker');
    }
}
