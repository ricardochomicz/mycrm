<?php

namespace App\Services;

use App\Models\OrderType;
use Illuminate\Support\Facades\DB;

class OrderTypeService
{
    public function toSelect($data = [])
    {
        return OrderType::where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('name')->get(['id', 'name']);
    }

    public function index($data)
    {
        $type = OrderType::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $type->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $type = new OrderType($data);
            $type->save();

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
            OrderType::with('tenant')->where('tenant_id',auth()->user()->tenant->id)->withTrashed()->find($id) :
            OrderType::with('tenant')->where('tenant_id',auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $type = $this->get($id);
            $type->update($data);

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
            $type = $this->get($id, true);
            if ($type->deleted_at != null) {
                $type->restore();
            } else {
                $type->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}