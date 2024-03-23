<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use App\Services\UserService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(
        protected TeamService $teamService,
        protected UserService $userService
    )
    {
    }

    public function index()
    {
        return view('app.teams.index');
    }

    public function create()
    {
        return view('app.teams.create');
    }

    public function store(Request $request)
    {
        $team = $this->teamService->store($request->all());
        if ($team) {
            flash()->addSuccess('Equipe cadastrada com sucesso.');
            return redirect()->route('teams.members.index', $team->id);
        } else {
            flash()->addError('Ops! Erro ao cadastrar Equipe.');
            return back();
        }
    }

    public function edit($id)
    {
        $team = $this->teamService->get($id);
        if(!$team){
            flash()->addError('Ops! Equipe não encontrada.');
            return back();
        }
        $view = [
            'data' => $team
        ];
        return view('app.teams.edit', $view);
    }

    public function update(Request $request, $id)
    {
        $team = $this->teamService->update($request->all(), $id);
        if ($team) {
            flash()->addSuccess('Equipe atualizada com sucesso.');
            return redirect()->route('teams.members.index', $team->id);
        } else {
            flash()->addError('Ops! Erro ao atualizar Equipe.');
            return back();
        }
    }

    public function members($id)
    {
        $team = $this->teamService->get($id);
        $view = [
            'data' => $team,
        ];
        return view('app.teams.members.index', $view);
    }

    public function editMembers($id)
    {
        $team = $this->teamService->get($id);
        $members = $team->members;

        $view = [
            'data' => $team,
            'members' => $members
        ];
        return view('app.teams.members.index', $view);
    }
}
