<?php

namespace App\Livewire\Category;

use App\Services\CategoryService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $trashed = '';

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
        $view = [
           'data' => $categories->index($filters)
        ];
        return view('livewire.category.table',$view);
    }

    public function clearFilter(): void
    {
        $this->search = '';
        $this->trashed = '';
        $this->dispatch('resetSelectpicker');
    }
}
