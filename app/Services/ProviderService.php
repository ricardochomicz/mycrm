<?php

namespace App\Services;

use App\Models\Provider;
use Illuminate\Support\Facades\DB;

class ProviderService
{

    public function index($data)
    {
        $provider = Provider::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $provider->paginate();

    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $provider = new Provider($data);
            $provider->save();

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
            Provider::with('tenant')->whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($id) :
            Provider::with('tenant')->whereTenantId(auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $provider = $this->get($id);
            $provider->update($data);

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
            $provider = $this->get($id, true);
            if ($provider->deleted_at != null) {
                $provider->restore();
            } else {
                $provider->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

}