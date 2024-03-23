<?php

namespace App\Services;

use App\Models\Team;
use Illuminate\Support\Facades\DB;

class TeamService
{
    public function index($data)
    {
        $teams = Team::with('supervisor')->whereTenantId(auth()->user()->tenant->id)->filter($data);
        return $teams->paginate();
    }

    public function store($data)
    {
        try {
            DB::beginTransaction();

            $data['tenant_id'] = auth()->user()->tenant->id;
            $team = new Team($data);
            $team->save();

            DB::commit();
            return $team;
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function get($id, $withTrashed = false)
    {
        return $withTrashed ?
            Team::whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($id) :
            Team::whereTenantId(auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $team = $this->get($id);
            $team->update($data);

            DB::commit();
            return $team;
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
            $team = $this->get($id, true);
            if ($team->deleted_at != null) {
                $team->restore();
            } else {
                $team->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}