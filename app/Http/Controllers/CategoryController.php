<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $view = [];
        return view('app.categories.index', $view);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('app.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $category = $this->categoryService->store($request->all());
        if ($category) {
            flash()->addSuccess('Categoria cadastrada com sucesso.');
            return redirect()->route('categories.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Categoria.');
            return back();
        }
    }



    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $category = $this->categoryService->get($id);
        if(!$category){
            flash()->addError('Ops! Categoria não encontrada.');
            return back();
        }
        $view = [
            'data' => $category
        ];

        return view('app.categories.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $category = $this->categoryService->update($request->all(), $id);
        if ($category) {
            flash()->addSuccess('Categoria atualizada com sucesso.');
            return redirect()->route('categories.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Categoria.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $category = $this->categoryService->get($id, true);
        $this->categoryService->destroy($id);
        if ($category->deleted_at === null) {
            flash()->addSuccess('Categoria desativada com sucesso.');
            return redirect()->route('categories.index');
        } elseif ($category->deleted_at != null) {
            flash()->addSuccess('Categoria reativada com sucesso.');
            return redirect()->route('categories.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Categoria.');
            return back();
        }
    }
}
