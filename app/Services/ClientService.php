<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientService
{

    public function index($data)
    {
        $category = Client::with('tenant')
            ->where('tenant_id', auth()->user()->tenant->id)
            ->filter($data);

        return $category->paginate();
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $data['user_id'] = auth()->user()->id;
            $client = new Client($data);
            $client->save();
            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        return $withTrashed ?
            Client::where('tenant_id', auth()->user()->tenant->id)->withTrashed()->find($id) :
            Client::where('tenant_id', auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        DB::beginTransaction();
        try {
            $client = $this->get($id);
            $client->update($data);
            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    public function active($id)
    {
        DB::beginTransaction();
        try {
            $client = $this->get($id, true);
            if ($client->deleted_at != '') {
                $client->restore();
            } else {
                $client->delete();
            }

            DB::commit();
            return $client;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}