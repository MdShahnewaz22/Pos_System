<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    protected $productModel;

    public function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    public function list()
    {
        return $this->productModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->productModel->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->productModel->find($id);
    }

    public function create(array $data)
    {
        return $this->productModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->productModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->productModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->productModel->findOrFail($request->id);

        $dataInfo->update(['status' => $request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->productModel->whereNull('deleted_at')->where('status', 'Active')->get();
    }

}
