<?php

namespace App\Livewire\Category;

use App\Services\CategoryService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public array $filters = ['search', 'trashed'];

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected array $queryString = [
        'filters.search' => ['except' => ''],
        'filters.trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = new CategoryService();
        return view('livewire.category.table', [
            'data' => $categories->index($this->filters),
        ]);
    }

    public function clearFilter(): void
    {
        $this->filters = [];
        $this->dispatch('resetSelectpicker');
    }
}
