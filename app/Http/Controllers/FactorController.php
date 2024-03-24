<?php

namespace App\Http\Controllers;

use App\Services\FactorService;
use App\Services\OperatorService;
use App\Services\OrderTypeService;
use Illuminate\Http\Request;

class FactorController extends Controller
{
    public function __construct(
        protected FactorService $factorService,
        protected OperatorService $operatorService,
        protected OrderTypeService $typeService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.factors.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = [
            'operators' => $this->operatorService->toSelect(),
            'types' => $this->typeService->toSelect(),
        ];
        return view('app.factors.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $factor = $this->factorService->store($request->all());
        if ($factor) {
            flash()->addSuccess('Fator cadastrado com sucesso.');
            return redirect()->route('factors.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Fator.');
            return back();
        }
    }



    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $factor = $this->factorService->get($id);
        if(!$factor){
            flash()->addError('Ops! Fator não encontrado.');
            return back();
        }
        $view = [
            'data' => $factor,
            'operators' => $this->operatorService->toSelect(),
            'types' => $this->typeService->toSelect(),
        ];

        return view('app.factors.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $factor = $this->factorService->update($request->all(), $id);
        if ($factor) {
            flash()->addSuccess('Fator atualizado com sucesso.');
            return redirect()->route('factors.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Fator.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $factor = $this->factorService->get($id, true);
        $this->factorService->destroy($id);
        if ($factor->deleted_at === null) {
            flash()->addSuccess('Fator desativado com sucesso.');
            return redirect()->route('factors.index');
        } elseif ($factor->deleted_at != null) {
            flash()->addSuccess('Fator reativado com sucesso.');
            return redirect()->route('factors.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Fator.');
            return back();
        }
    }
}
