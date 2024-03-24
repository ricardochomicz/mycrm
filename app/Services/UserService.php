<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserService
{
    public function toSelect($data = [])
    {
        return User::where('tenant_id', auth()->user()->tenant->id)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', 6); //user
            })
            ->orderBy('name')->get(['id', 'name']);
    }

    public function toSelectSupervisor()
    {
        return User::where('tenant_id', auth()->user()->tenant->id)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', 4); //supervisor
            })
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function toSelectUsers($filter = false)
    {
        return User::where('tenant_id', auth()->user()->tenant->id)
            ->whereHas('roles', function ($query) {
                $query->where('role_id', 6); //usuário
            })
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')
                    ->from('team_user');
            })
            ->when($filter, function ($query, $filter) {
                $query->where('name', 'like', '%' . $filter . '%');
            })
            ->orderBy('name')
            ->get()->toArray();
    }


    public function index($data)
    {
        if (Gate::allows('isSuperAdmin')) {
            $user = User::with('tenant')
                ->whereTenantId(auth()->user()->tenant->id)
                ->filter($data);
        } elseif (Gate::allows('isAdmin')) {
            $user = User::with('tenant')
                ->whereTenantId(auth()->user()->tenant->id)
                ->where('id', '<>', 1)
                ->filter($data);
        } else {
            $user = User::with('tenant')
                ->whereTenantId(auth()->user()->tenant->id)
                ->where('id', auth()->user()->id)
                ->filter($data);
        }


        return $user->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            if (isset($data['password']) && $data['password'] != '') {
                $data['password'] = bcrypt($data['password']);
            } else {
                $data['password'] = bcrypt($this->formatPhone($data['phone']));
            }

            $user = new User($data);
            $user->save();

            $user->roles()->attach($data['role_id']);

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
        if (Gate::allows('isAdmin')) {
            return $withTrashed ?
                User::with('tenant')->whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($id) :
                User::with('tenant')->whereTenantId(auth()->user()->tenant->id)->find($id);
        } else {
            return $withTrashed ?
                User::with('tenant')->whereTenantId(auth()->user()->tenant->id)->whereId(auth()->user()->id)->withTrashed()->find($id) :
                User::with('tenant')->whereTenantId(auth()->user()->tenant->id)->whereId(auth()->user()->id)->find($id);
        }
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $user = $this->get($id);

            if (isset($data['image'])) {
                if (file_exists($data['image'])) {
                    $data['image'] = $this->uploadFile($data['image'], $user->id);
                    if ($user->image) {
                        Storage::disk('public')->delete($user->image);
                    }
                }
            }

            $user->update($data);

            if ($data['role_id'] != '') {
                $user->roles()->sync($data['role_id']);
            }


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
            $user = $this->get($id, true);
            if ($user->deleted_at != null) {
                $user->restore();
            } else {
                $user->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }

    private function formatPhone($value): array|string
    {
        return str_replace(' ', '', str_replace('-', '', $value));
    }

    private function uploadFile($data, $id)
    {
        return $data->store('/tenant/' . auth()->user()->tenant->id . '/user/' . $id, "public");
    }

}