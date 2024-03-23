<?php

namespace App\Http\Controllers;

use App\Models\CurrentAccount;
use App\Services\CurrentAccountService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class CurrentAccountController extends Controller
{

    public function __construct(protected CurrentAccountService $accountService, protected TenantService $tenantService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.current_accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = [
            'tenants' => $this->tenantService->toSelect()
        ];
        return view('app.current_accounts.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $account = $this->accountService->store($request->all());
        if ($account) {
            flash()->addSuccess('Conta cadastrada com sucesso.');
            return redirect()->route('current.accounts.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Conta.');
            return back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $account = $this->accountService->get($id);
        if(!$account){
            flash()->addError('Ops! Conta Corrente não encontrada.');
            return back();
        }
        $view = [
            'tenants' => $this->tenantService->toSelect(),
            'data' => $account
        ];
        return view('app.current_accounts.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $account = $this->accountService->update($request->all(), $id);
        if ($account) {
            flash()->addSuccess('Conta atualizada com sucesso.');
            return redirect()->route('current.accounts.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Conta.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account = $this->accountService->get($id, true);
        $this->accountService->destroy($id);
        if ($account->deleted_at === null) {
            flash()->addSuccess('Conta desativada com sucesso.');
            return redirect()->route('current.accounts.index');
        } elseif ($account->deleted_at != null) {
            flash()->addSuccess('Conta reativada com sucesso.');
            return redirect()->route('current.accounts.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar conta.');
            return back();
        }
    }
}
