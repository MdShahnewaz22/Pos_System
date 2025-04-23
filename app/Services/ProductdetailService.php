<?php

namespace App\Services;

use App\Models\Productdetail;

class ProductdetailService
{
    protected $productdetailModel;

    public function __construct(Productdetail $productdetailModel)
    {
        $this->productdetailModel = $productdetailModel;
    }

    public function list()
    {
        return $this->productdetailModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->productdetailModel->whereNull('deleted_at')->all();
    }

    public function find($id)
    {
        return $this->productdetailModel->find($id);
    }

    public function create(array $data)
    {
        return $this->productdetailModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->productdetailModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->productdetailModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->productdetailModel->findOrFail($request->id);

        $dataInfo->update(['status' => $request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->productdetailModel->whereNull('deleted_at')->where('status', 'Active')->get();
    }

}
