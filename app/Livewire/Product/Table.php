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

    public array $filters = ['search', 'operator', 'category', 'trashed'];

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'filters.search' => ['except' => ''],
        'filters.operator' => ['except' => ''],
        'filters.category' => ['except' => ''],
        'filters.trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $products = new ProductService();
        $operators = new OperatorService();
        $categories = new CategoryService();
        return view('livewire.product.table', [
            'data' => $products->index($this->filters),
            'operators' => $operators->toSelect(),
            'categories' => $categories->toSelect()
        ]);
    }

    public function clearFilter(): void
    {
        $this->filters = [];
        $this->dispatch('resetSelectpicker');
    }
}
