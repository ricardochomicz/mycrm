<?php

namespace App\Http\Controllers;

use App\Services\OrderTypeService;
use Illuminate\Http\Request;

class OrderTypeController extends Controller
{
    public function __construct(protected OrderTypeService $typeService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.order-types.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.order-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $type = $this->typeService->store($request->all());
        if ($type) {
            flash()->addSuccess('Tipo Pedido cadastrado com sucesso.');
            return redirect()->route('order-types.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Tipo Pedido.');
            return back();
        }
    }



    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $type = $this->typeService->get($id);
        if(!$type){
            flash()->addError('Ops! Tipo Pedido não encontrado.');
            return back();
        }
        $view = [
            'data' => $type,
        ];

        return view('app.order-types.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $type = $this->typeService->update($request->all(), $id);
        if ($type) {
            flash()->addSuccess('Tipo Pedido atualizado com sucesso.');
            return redirect()->route('order-types.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Tipo Pedido.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $type = $this->typeService->get($id, true);
        $this->typeService->destroy($id);
        if ($type->deleted_at === null) {
            flash()->addSuccess('Tipo Pedido desativado com sucesso.');
            return redirect()->route('order-types.index');
        } elseif ($type->deleted_at != null) {
            flash()->addSuccess('Tipo Pedido reativado com sucesso.');
            return redirect()->route('order-types.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Tipo Pedido.');
            return back();
        }
    }
}
