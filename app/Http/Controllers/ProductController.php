<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\CategoryService;
use App\Services\OperatorService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected OperatorService $operatorService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $view = [
            'categories' => $this->categoryService->toSelect(),
            'operators' => $this->operatorService->toSelect()
        ];
        return view('app.products.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request->all());
        if ($product) {
            flash()->addSuccess('Produto cadastrado com sucesso.');
            return redirect()->route('products.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar Produto.');
            return back();
        }
    }



    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $product = $this->productService->get($id);
        if(!$product){
            flash()->addError('Ops! Produto não encontrado.');
            return back();
        }
        $view = [
            'data' => $product,
            'operators' => $this->operatorService->toSelect(),
            'categories' => $this->categoryService->toSelect()
        ];

        return view('app.products.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $product = $this->productService->update($request->all(), $id);
        if ($product) {
            flash()->addSuccess('Produto atualizado com sucesso.');
            return redirect()->route('products.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Produto.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $product = $this->productService->get($id, true);
        $this->productService->destroy($id);
        if ($product->deleted_at === null) {
            flash()->addSuccess('Produto desativado com sucesso.');
            return redirect()->route('products.index');
        } elseif ($product->deleted_at != null) {
            flash()->addSuccess('Produto reativado com sucesso.');
            return redirect()->route('products.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar Produto.');
            return back();
        }
    }
}
