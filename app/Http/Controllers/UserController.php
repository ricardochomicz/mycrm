<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected RoleService $roleService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('app.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('isAdmin');
        $view = [
            'roles' => $this->roleService->toSelect()
        ];
        return view('app.users.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user = $this->userService->store($request->all());
        if ($user) {
            flash()->addSuccess('Usuário cadastrado com sucesso.');
            return redirect()->route('users.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Usuário.');
            return back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $user = $this->userService->get($id);
        if(!$user){
            flash()->addError('Ops! Usuário não encontrado.');
            return back();
        }
        $view = [
            'roles' => $this->roleService->toSelect(),
            'data' => $user
        ];

        return view('app.users.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $user = $this->userService->update($request->all(), $id);
        if ($user) {
            flash()->addSuccess('Usuário atualizado com sucesso.');
            return redirect()->route('users.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Usuário.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->userService->get($id, true);
        $this->userService->destroy($id);
        if ($user->deleted_at === null) {
            flash()->addSuccess('Usuário desativado com sucesso.');
            return redirect()->route('users.index');
        } elseif ($user->deleted_at != null) {
            flash()->addSuccess('Usuário reativado com sucesso.');
            return redirect()->route('users.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Usuário.');
            return back();
        }
    }
}
