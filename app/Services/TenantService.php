<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TenantService
{

    public function toSelect($data = [])
    {
        return Tenant::where('id', auth()->user()->tenant->id)
            ->orderBy('name')->get(['id', 'name']);
    }


    public function index($data)
    {
        if(Gate::allows('isSuperAdmin', auth()->user())){
            return Tenant::filter($data)->paginate();
        }else{
            return Tenant::filter($data)->where('id', auth()->user()->tenant->id)->paginate();
        }
    }


    public function store($data): bool
    {
        try {
            DB::beginTransaction();

            $tenant = new Tenant($data);
            $tenant->save();

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            DB::rollBack();
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        if(Gate::allows('isSuperAdmin', auth()->user())){
            return $withTrashed ?
                Tenant::withTrashed()->find($id) :
                Tenant::find($id);
        }else{
            return $withTrashed ?
                Tenant::where('id', auth()->user()->tenant->id)->withTrashed()->find($id) :
                Tenant::where('id', auth()->user()->tenant->id)->find($id);
        }
    }

    public function update($data, $id): bool
    {

        try {
            DB::beginTransaction();

            $tenant = $this->get($id);

            if (!isset($data['active'])) {
                $data['active'] = 0;
            }

            if (isset($data['logo'])) {
                if (file_exists($data['logo'])) {
                    $data['logo'] = $this->uploadFile($data['logo'], $tenant->id);
                    if ($tenant->logo) {
                        Storage::disk('public')->delete($tenant->logo);
                    }
                }
            }

            $tenant->update($data);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            DB::beginTransaction();
            $tenant = $this->get($id, true);
            if ($tenant->deleted_at != null) {
                $tenant->restore();
            } else {
                $tenant->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function uploadFile($data, $id)
    {
        return $data->store('/tenant/' . $id, "public");
    }
}