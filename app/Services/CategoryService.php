<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    public function toSelect($data = [])
    {
        return Category::where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('name')->get(['id', 'name']);
    }

    public function index($data)
    {
        $category = Category::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $category->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $category = new Category($data);
            $category->save();

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
            Category::with('tenant')->whereTenantId(auth()->user()->tenant->id)->withTrashed()->find($id) :
            Category::with('tenant')->whereTenantId(auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $category = $this->get($id);
            $category->update($data);

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
            $category = $this->get($id, true);
            if ($category->deleted_at != null) {
                $category->restore();
            } else {
                $category->delete();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }
    }
}