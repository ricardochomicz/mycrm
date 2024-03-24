<?php

namespace App\Http\Controllers;

use App\Services\ClassificationService;
use Illuminate\Http\Request;

class ClassificationController extends Controller
{
    public function __construct(protected ClassificationService $classificationService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.classifications.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.classifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $classification = $this->classificationService->store($request->all());
        if ($classification) {
            flash()->addSuccess('Classificação cadastrada com sucesso.');
            return redirect()->route('classifications.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Classificação.');
            return back();
        }
    }



    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $classification = $this->classificationService->get($id);
        if(!$classification || $classification->id === 1){
            flash()->addError('Ops! Classificação não encontrada, ou registro não pode ser editado.');
            return back();
        }
        $view = [
            'data' => $classification
        ];

        return view('app.classifications.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $classification = $this->classificationService->update($request->all(), $id);
        if ($classification) {
            flash()->addSuccess('Classificação atualizada com sucesso.');
            return redirect()->route('classifications.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Classificação.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $classification = $this->classificationService->get($id, true);
        $this->classificationService->destroy($id);
        if ($classification->deleted_at === null) {
            flash()->addSuccess('Classificação desativada com sucesso.');
            return redirect()->route('classifications.index');
        } elseif ($classification->deleted_at != null) {
            flash()->addSuccess('Classificação reativada com sucesso.');
            return redirect()->route('classifications.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Classificação.');
            return back();
        }
    }
}
