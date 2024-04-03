<?php

namespace App\Services;

use App\Models\RevenueExpense;
use Illuminate\Support\Facades\DB;

class RevenueExpenseService
{
    public function toSelect()
    {
        return RevenueExpense::where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function index($data)
    {
        $revenues = RevenueExpense::with('tenant')
            ->where('tenant_id', auth()->user()->tenant->id)
            ->filter($data);
        return $revenues->paginate();
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();

            $data['tenant_id'] = auth()->user()->tenant->id;
            $revenue = new RevenueExpense($data);
            $revenue->save();

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        return $withTrashed ?
            RevenueExpense::with('tenant')->whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($id) :
            RevenueExpense::with('tenant')->whereTenantId(auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $revenue = $this->get($id);
            $revenue->update($data);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            DB::beginTransaction();
            $revenue = $this->get($id, true);
            if ($revenue->deleted_at != null) {
                $revenue->restore();
            } else {
                $revenue->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function types()
    {
        $result = [];
        $obj = new \stdClass();
        $obj->id = "credit";
        $obj->name = 'Receita';
        $result[] = $obj;
        $obj = new \stdClass();
        $obj->id = "debit";
        $obj->name = 'Despesa';
        $result[] = $obj;
        return $result;
    }

}