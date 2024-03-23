<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    public function __construct(protected ProviderService $providerService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.providers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $provider = $this->providerService->store($request->all());
        if ($provider) {
            flash()->addSuccess('Fornecedor cadastrado com sucesso.');
            return redirect()->route('providers.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Fornecedor.');
            return back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $provider = $this->providerService->get($id);
        if(!$provider){
            flash()->addError('Ops! Fornecedor não encontrado.');
            return back();
        }
        $view = [
            'provider' => $provider
        ];

        return view('app.providers.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $provider = $this->providerService->update($request->all(), $id);
        if ($provider) {
            flash()->addSuccess('Fornecedor atualizado com sucesso.');
            return redirect()->route('providers.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Fornecedor.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $provider = $this->providerService->get($id, true);
        $this->providerService->destroy($id);
        if ($provider->deleted_at === null) {
            flash()->addSuccess('Fornecedor desativado com sucesso.');
            return redirect()->route('providers.index');
        } elseif ($provider->deleted_at != null) {
            flash()->addSuccess('Fornecedor reativado com sucesso.');
            return redirect()->route('providers.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar fornecedor.');
            return back();
        }
    }
}
