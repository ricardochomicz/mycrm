<?php

namespace App\Livewire\Team;

use App\Services\TeamService;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;
    protected string $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $trashed = '';

    protected $listeners = ['resetSelectpicker' => '$refresh'];

    protected $queryString = [
        'search' => ['except' => ''],
        'trashed' => ['except' => ''],
    ];

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $teams = new TeamService();
        $filters = [
            'search' => $this->search,
            'trashed' => $this->trashed
        ];
        return view('livewire.team.table', [
            'data' => $teams->index($filters),
        ]);
    }

    public function clearFilter(): void
    {
        $this->search = '';
        $this->trashed = '';
        $this->emit('resetSelectpicker');
    }
}
