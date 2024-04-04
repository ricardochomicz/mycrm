<?php

namespace App\Http\Controllers;

use App\Services\ProviderService;
use App\Services\RevenueExpenseService;
use Illuminate\Http\Request;

class RevenueExpenseController extends Controller
{
    public function __construct(
        protected RevenueExpenseService $revenueService,
    )
    {
    }

    public function index()
    {
        return view('app.revenue_expenses.index');
    }

    public function create()
    {
        $view = [
            'types' => $this->revenueService->types()
        ];
        return view('app.revenue_expenses.create', $view);
    }

    public function store(Request $request)
    {
        $revenue = $this->revenueService->store($request->all());
        if ($revenue) {
            flash()->addSuccess('Tipo Receita/Despesa cadastrada com sucesso.');
            return redirect()->route('revenue-expenses.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Tipo Receita/Despesa.');
            return back();
        }
    }

    public function edit($id)
    {
        $revenue = $this->revenueService->get($id);
        if(!$revenue){
            flash()->addError('Ops! Tipo Receita/Despesa não encontrada.');
            return back();
        }
        $view = [
            'types' => $this->revenueService->types(),
            'data' => $revenue
        ];

        return view('app.revenue_expenses.edit', $view);
    }

    public function update(Request $request, $id)
    {
        $revenue = $this->revenueService->update($request->all(), $id);
        if ($revenue) {
            flash()->addSuccess('Tipo Receita/Despesa atualizada com sucesso.');
            return redirect()->route('revenue-expenses.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Tipo Receita/Despesa.');
            return back();
        }
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $revenue = $this->revenueService->get($id, true);
        $this->revenueService->destroy($id);
        if ($revenue->deleted_at === null) {
            flash()->addSuccess('Tipo Receita/Despesa desativada com sucesso.');
            return redirect()->route('revenue-expenses.index');
        } elseif ($revenue->deleted_at != null) {
            flash()->addSuccess('Tipo Receita/Despesa com sucesso.');
            return redirect()->route('revenue-expenses.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Tipo Receita/Despesa.');
            return back();
        }
    }
}
