<?php

namespace App\Services;

use App\Models\CurrentAccount;
use Illuminate\Support\Facades\DB;

class CurrentAccountService
{

    public function index($data)
    {
        $account = CurrentAccount::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $account->paginate();

    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();

            $data['tenant_id'] = auth()->user()->tenant->id;
            $account = new CurrentAccount($data);
            $account->save();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function get($currentAccount, $withTrashed = false)
    {
        if ($withTrashed) {
            return CurrentAccount::with('tenant')->whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($currentAccount);
        } else {
            return CurrentAccount::with('tenant')->whereTenantId(auth()->user()->tenant->id)->find($currentAccount);
        }
    }

    public function update($data, $id): bool
    {
        try {
            DB::beginTransaction();

            $account = $this->get($id);
            $account->update($data);

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
            $account = $this->get($id, true);
            if ($account->deleted_at != null) {
                $account->restore();
            } else {
                $account->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }


}