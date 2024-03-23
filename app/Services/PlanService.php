<?php

namespace App\Services;

use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class PlanService
{

    public function toSelect($data = [])
    {
        return Plan::orderBy('name')->get(['id', 'name']);
    }

    public function index($data)
    {
        $plan = Plan::filter($data);
        return $plan->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $plan = new Plan($data);
            $plan->save();

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        return $withTrashed ?
            Plan::withTrashed()->find($id) :
            Plan::find($id);
    }

    public function update($data, $id): bool
    {
        try {
            DB::beginTransaction();

            $plan = $this->get($id);
            $plan->update($data);

            DB::commit();
            return true;
        } catch (\Throwable $e) {
            dd($e);
            DB::rollBack();
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            DB::beginTransaction();
            $plan = $this->get($id, true);
            if ($plan->deleted_at != null) {
                $plan->restore();
            } else {
                $plan->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }


}