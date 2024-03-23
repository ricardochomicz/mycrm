<?php

namespace App\Http\Controllers;

use App\Services\OperatorService;
use Illuminate\Http\Request;

class OperatorController extends Controller
{
    public function __construct(protected OperatorService $operatorService)
    {
    }

    public function index()
    {
        return view('app.operators.index');
    }

    public function create()
    {
        return view('app.operators.create');
    }

    public function store(Request $request)
    {
        $operator = $this->operatorService->store($request->all());
        if ($operator) {
            flash()->addSuccess('Operadora cadastrada com sucesso.');
            return redirect()->route('operators.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Operadora.');
            return back();
        }
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $operator = $this->operatorService->get($id);
        if(!$operator){
            flash()->addError('Ops! Operadora não encontrada.');
            return back();
        }
        $view = [
            'data' => $operator
        ];

        return view('app.operators.edit', $view);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $operator = $this->operatorService->update($request->all(), $id);
        if ($operator) {
            flash()->addSuccess('Operadora atualizada com sucesso.');
            return redirect()->route('operators.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Operadora.');
            return back();
        }
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $operator = $this->operatorService->get($id, true);
        $this->operatorService->destroy($id);
        if ($operator->deleted_at === null) {
            flash()->addSuccess('Operadora desativada com sucesso.');
            return redirect()->route('operators.index');
        } elseif ($operator->deleted_at != null) {
            flash()->addSuccess('Operadora reativada com sucesso.');
            return redirect()->route('operators.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Operadora.');
            return back();
        }
    }
}
