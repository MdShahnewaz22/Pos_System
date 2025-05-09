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
        return $this->productdetailModel->whereNull('deleted_at')->get();
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

 
}
