<?php

namespace App\Livewire\User;

use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public array $filters = ['search', 'trashed'];

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'filters.search' => ['except' => ''],
        'filters.trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = new UserService();
        return view('livewire.user.table', [
            'data' => $users->index($this->filters),
        ]);
    }

    public function clearFilter(): void
    {
        $this->filters = [];
        $this->dispatch('resetSelectpicker');
    }
}
