<?php

namespace App\Services;

use App\Models\Shippingdetail;

class ShippingdetailService
{
    protected $shippingdetailModel;

    public function __construct(Shippingdetail $shippingdetailModel)
    {
        $this->shippingdetailModel = $shippingdetailModel;
    }

    public function list()
    {
        return $this->shippingdetailModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->shippingdetailModel->whereNull('deleted_at')->get();
    }

    public function find($id)
    {
        return $this->shippingdetailModel->find($id);
    }

    public function create(array $data)
    {
        return $this->shippingdetailModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->shippingdetailModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->shippingdetailModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->shippingdetailModel->findOrFail($request->id);

        $dataInfo->update(['status' => $request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->shippingdetailModel->whereNull('deleted_at')->where('status', 'Active')->get();
    }

}
