<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function toSelect($data = [])
    {
        return Product::where('tenant_id', auth()->user()->tenant->id)
            ->orderBy('name')->get(['id', 'name']);
    }

    public function index($data)
    {
        $product = Product::with('tenant')
            ->whereTenantId(auth()->user()->tenant->id)
            ->filter($data);

        return $product->paginate();
    }

    public function store($data): bool
    {
        try {
            DB::beginTransaction();
            $data['tenant_id'] = auth()->user()->tenant->id;
            $product = new Product($data);
            $product->save();

            if(isset($data['image'])){
                $data['image'] = $this->uploadFile($data['image'], $product->id);
                $product->update($data);
            }

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
            Product::with('tenant')->where('tenant_id',auth()->user()->tenant->id)->withTrashed()->find($id) :
            Product::with('tenant')->where('tenant_id',auth()->user()->tenant->id)->find($id);
    }

    public function update($data, $id)
    {
        try {
            DB::beginTransaction();

            $product = $this->get($id);

            if(isset($data['image'])){
                if(file_exists($data['image'])){

                    if($product->image){
                        Storage::disk('public')->delete($product->image);
                    }
                    $data['image'] = $this->uploadFile($data['image'], $product->id);
                }
            }


            $product->update($data);

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
            $product = $this->get($id, true);
            if ($product->deleted_at != null) {
                $product->restore();
            } else {
                $product->delete();
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
        return $data->store('/tenant/' . auth()->user()->tenant->id . '/product/' . $id, "public");
    }
}