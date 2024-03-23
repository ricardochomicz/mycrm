<?php

namespace App\Http\Controllers;

use App\Services\PlanService;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(protected PlanService $planService)
    {
    }

    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('app.plans.index');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('app.plans.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $plan = $this->planService->store($request->all());
        if ($plan) {
            flash()->addSuccess('Plano cadastrado com sucesso.');
            return redirect()->route('plans.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Plano.');
            return back();
        }
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $plan = $this->planService->get($id);
        if(!$plan){
            flash()->addError('Ops! Categoria não encontrada.');
            return back();
        }
        $view = [
            'data' => $plan
        ];
        return view('app.plans.edit', $view);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $plan = $this->planService->update($request->all(), $id);
        if ($plan) {
            flash()->addSuccess('Plano atualizado com sucesso.');
            return redirect()->route('plans.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Plano.');
            return back();
        }
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $plan = $this->planService->get($id, true);
        $this->planService->destroy($id);
        if ($plan->deleted_at === null) {
            flash()->addSuccess('Plano desativado com sucesso.');
            return redirect()->route('plans.index');
        } elseif ($plan->deleted_at != null) {
            flash()->addSuccess('Plano reativado com sucesso.');
            return redirect()->route('plans.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Plano.');
            return back();
        }
    }
}
