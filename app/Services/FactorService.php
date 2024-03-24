<?php

namespace App\Services;

use App\Models\Factor;
use Illuminate\Support\Facades\DB;

class FactorService
{
    public function toSelect($data = [])
    {
        return Factor::where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('name')->get(['id', 'name']);
    }

    public function index($data)
    {
        $factor = Factor::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $factor->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $factor = new Factor($data);
            $factor->save();

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
            Factor::with('tenant')->where('tenant_id',auth()->user()->tenant->id)->withTrashed()->find($id) :
            Factor::with('tenant')->where('tenant_id',auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $factor = $this->get($id);
            $factor->update($data);

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
            $factor = $this->get($id, true);
            if ($factor->deleted_at != null) {
                $factor->restore();
            } else {
                $factor->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}