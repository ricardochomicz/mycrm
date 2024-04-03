<?php

namespace App\Services;

use App\Models\Account;
use App\Models\AccountParcel;
use Illuminate\Support\Facades\DB;

class AccountService
{
    public function index($data)
    {
        $account = AccountParcel::with('account')
            ->where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('due_date', 'asc')
            ->filter($data);

        return $account->paginate();
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();

            $data['tenant_id'] = auth()->user()->tenant->id;
            $data['user_id'] = auth()->user()->id;
            $data['total'] = (float) $data['value'] * $data['qty'];
            $account = new Account($data);
            $account->save();

            $this->createParcels($data, $account->id);

            DB::commit();
            return true;
        }catch (\Throwable $e){
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        return $withTrashed ?
            Account::with('tenant')->where('tenant_id', auth()->user()->tenant->id)->withTrashed()->find($id) :
            Account::with('tenant')->where('tenant_id', auth()->user()->tenant->id)->find($id);
    }

    public function getParcel($id, $withTrashed = false)
    {
        return $withTrashed ?
            AccountParcel::with('tenant')->where('tenant_id', auth()->user()->tenant->id)->withTrashed()->find($id) :
            AccountParcel::with('tenant')->where('tenant_id', auth()->user()->tenant->id)->find($id);
    }

    public function updateParcel($data, $id)
    {
        try {
            DB::beginTransaction();

            $parcel = $this->getParcel($id);
            if(isset($data['payment']) && $data['payment'] != ''){
                $data['payment_status'] = 1;
            }


            $dataUpdate = [
                'value' => $data['value'],
                'payment' => $data['payment'],
                'payment_interest' => $data['payment_interest'],
                'payment_status' => $data['payment'] ? $data['payment_status'] = 1 : 0
            ];
            $dataAccount = [
                'id' => $parcel->account_id,
                'provider_id' => $data['provider_id'],
                'revenue_expense_id' => $data['revenue_expense_id'],
                'description' => $data['description']
            ];
            $account = $this->get($parcel->account_id);
            $account->update($dataAccount);
            $parcel->update($dataUpdate);

            DB::commit();
            return true;
        }catch (\Throwable $e){
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $parcel = $this->getParcel($id, true);
            if ($parcel->deleted_at != null) {
                $parcel->restore();
            } else {
                $parcel->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function createParcels($data, $id){
        $qtyParcels = $data['qty'];
        $dueDate = $data['due_date'];
        $valueParcel = $data['value'];

        for ($i = 0; $i < $qtyParcels; $i++) {
            $dDate = date('Y-m-d', strtotime("+$i month", strtotime($dueDate)));

            AccountParcel::create([
                'tenant_id' => auth()->user()->tenant->id,
                'user_id' => auth()->user()->id,
                'account_id' => $id,
                'number_parcel' => $i + 1,
                'due_date' => $dDate,
                'value' => $valueParcel,
            ]);
        }
    }
}