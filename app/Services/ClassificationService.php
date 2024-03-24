<?php

namespace App\Services;

use App\Models\Classification;
use Illuminate\Support\Facades\DB;

class ClassificationService
{
    public function toSelect($data = [])
    {
        return Classification::where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('name')->get(['id', 'name', 'months as text']);
    }

    public function index($data)
    {
        $classification = Classification::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $classification->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $classification = new Classification($data);
            $classification->save();

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
            Classification::with('tenant')->whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($id) :
            Classification::with('tenant')->whereTenantId(auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $classification = $this->get($id);
            $classification->update($data);

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
            $classification = $this->get($id, true);
            if ($classification->deleted_at != null) {
                $classification->restore();
            } else {
                $classification->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}