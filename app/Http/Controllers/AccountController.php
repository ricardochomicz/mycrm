<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Services\AccountService;
use App\Services\ProviderService;
use App\Services\RevenueExpenseService;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function __construct(
        protected AccountService $accountService,
        protected ProviderService $providerService,
        protected RevenueExpenseService $revenueService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.accounts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = [
            'providers' => $this->providerService->toSelect(),
            'revenues' => $this->revenueService->toSelect(),
            'disableQtyInput' => false
        ];
         return view('app.accounts.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $account = $this->accountService->store($request->all());
        if ($account) {
            flash()->addSuccess('Conta cadastrada com sucesso.');
            return redirect()->route('accounts.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Conta.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $view = [
            'providers' => $this->providerService->toSelect(),
            'revenues' => $this->revenueService->toSelect(),
            'data' => $this->accountService->getParcel($id),
            'disableQtyInput' => true
        ];

        return view('app.accounts.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $this->accountService->updateParcel($request->all(), $id);
        if ($data) {
            flash()->addSuccess('Conta atualizada com sucesso.');
            return redirect()->route('accounts.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Conta.');
            return back();
        }

    }

    public function accountDetail($id)
    {
        $view = [
            'account' => $this->accountService->get($id),
            'providers' => $this->providerService->toSelect(),
            'revenues' => $this->revenueService->toSelect(),
        ];
        return view('app.accounts.show', $view);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account = $this->accountService->getParcel($id, true);
        $this->accountService->destroy($id);
        if ($account->deleted_at === null) {
            flash()->addSuccess('Conta desativada com sucesso.');
            return redirect()->route('accounts.index');
        } elseif ($account->deleted_at != null) {
            flash()->addSuccess('Conta reativada com sucesso.');
            return redirect()->route('accounts.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Categoria.');
            return back();
        }
    }
}
