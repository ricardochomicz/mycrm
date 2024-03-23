<?php

namespace App\Livewire\Team\Members;

use App\Models\Team;
use App\Models\User;
use App\Services\UserService;
use Livewire\Component;

class Form extends Component
{
    public array $selectedUsers = [];
    public $supervisor_id;
    public $team;
    public array $members = [];
    public string $search = '';
    public $membersCount;

    public function mount(Team $team, UserService $userService): void
    {
//        $this->team = $team->id;
//        $this->supervisor_id = $team->supervisor_id;
//        $teamMembers = $team->members->toArray();
//        $availableUsers = $this->availableUsers()->get()->toArray();
//
//        $this->members = array_merge($teamMembers, $availableUsers);
//
//        foreach ($team->members as $member) {
//            $this->selectedUsers[$member->id] = true;
//        }
        $this->team = $team->id;
        $this->supervisor_id = $team->supervisor_id;
        $this->updateMembers();
    }

    public function updateSearch(): void
    {
        $this->updateMembers();
    }

    private function updateMembers(): void
    {
        $userService = new UserService();
        $team = Team::find($this->team);
        $teamMembers = $team->members->toArray();
        $this->membersCount = count($teamMembers);

        // Atualiza os membros da equipe de acordo com a pesquisa
        $this->members = $userService->toSelectUsers($this->search);

        // Combina os membros da equipe com os membros filtrados
        $this->members = array_merge($teamMembers, $this->members);

        // Define os membros selecionados
        foreach ($team->members as $member) {
            $this->selectedUsers[$member->id] = true;
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $userService = new UserService();

        $view = [
            'supervisor' => $userService->toSelectSupervisor()
        ];
        return view('livewire.team.members.form', $view);
    }

    public function submit(): void
    {
        if (empty($this->supervisor_id)) {
            flash()->addError('Por favor, selecione um supervisor e configure a equipe.');
            return;
        }

        $team = Team::find($this->team);

        $team->supervisor_id = $this->supervisor_id;
        $team->save();

        $selectedUserIds = array_keys(array_filter($this->selectedUsers));

        $team->members()->sync($selectedUserIds);

        flash()->addSuccess('Usuário adicionado com sucesso.');
        $this->redirectRoute('teams.index');
    }

}
