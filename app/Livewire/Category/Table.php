<?php

namespace App\Livewire\Category;

use App\Services\CategoryService;
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
        $categories = new CategoryService();
        $filters = [
            'search' => $this->search,
            'trashed' => $this->trashed
        ];

        return view('livewire.category.table',[
            'data' => $categories->index($filters)
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
        $this->trashed = '';
        $this->emit('resetSelectpicker');
    }
}
