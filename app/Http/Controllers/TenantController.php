<?php

namespace App\Http\Controllers;

use App\Http\Requests\TenantRequest;
use App\Models\Tenant;
use App\Services\PlanService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantController extends Controller
{

    public function __construct(
        protected TenantService $tenantService,
        protected PlanService   $planService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('app.tenants.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $this->authorize('isSuperAdmin');
        $view = [
            'plans' => $this->planService->toSelect()
        ];
        return view('app.tenants.create', $view);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TenantRequest $request): \Illuminate\Http\RedirectResponse
    {
        $tenant = $this->tenantService->store($request->all());
        if ($tenant) {
            flash()->addSuccess('Empresa cadastrada com sucesso.');
            return redirect()->route('tenants.index');
        } else {
            flash()->addError('Ops! Erro ao cadastrar empresa.');
            return back();
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tenant = $this->tenantService->get($id);
        if (!$tenant) {
            flash()->addError('Ops! Empresa não encontrada.');
            return back();
        }
        $view = [
            'data' => $tenant,
            'plans' => $this->planService->toSelect()
        ];

        return view('app.tenants.edit', $view);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TenantRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $ten = $this->tenantService->update($request->all(), $id);
        if ($ten) {
            flash()->addSuccess('Empresa atualizada com sucesso.');
            return redirect()->route('tenants.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar empresa.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $t = $this->tenantService->get($id, true);
        $this->tenantService->destroy($id);

        if ($t->deleted_at === null) {
            flash()->addSuccess('Empresa desativada com sucesso.');
            return redirect()->route('tenants.index');
        } elseif ($t->deleted_at != null) {
            flash()->addSuccess('Empresa reativada com sucesso.');
            return redirect()->route('tenants.index');
        } else {
            flash()->addError('Ops! Erro ao atualizar empresa.');
            return back();
        }
    }
}
