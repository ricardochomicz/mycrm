<?php

namespace App\Services;

use App\Models\Operator;
use Illuminate\Support\Facades\DB;

class OperatorService
{
    public function toSelect()
    {
        return Operator::get(['id', 'name']);
    }

    public function index()
    {

    }

    public function store($data): bool
    {
        try{
            DB::beginTransaction();
            $operator = new Operator($data);
            $operator->save();

            DB::commit();
            return true;
        }catch (\Throwable $e){
            DB::rollBack();
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        return $withTrashed ?
            Operator::withTrashed()->find($id) :
            Operator::find($id);
    }

    public function update($data, $id): bool
    {
        try{
            DB::beginTransaction();
            $operator = $this->get($id);
            $operator->update($data);

            DB::commit();
            return true;
        }catch (\Throwable $e){
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            DB::beginTransaction();
            $operator = $this->get($id, true);
            if ($operator->deleted_at != null) {
                $operator->restore();
            } else {
                $operator->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}