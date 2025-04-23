<?php

namespace App\Services;

use App\Models\Size;

class SizeService
{
    protected $sizeModel;

    public function __construct(Size $sizeModel)
    {
        $this->sizeModel = $sizeModel;
    }

    public function list()
    {
        return $this->sizeModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->sizeModel->whereNull('deleted_at')->get();
    }

    public function find($id)
    {
        return $this->sizeModel->find($id);
    }

    public function create(array $data)
    {
        return $this->sizeModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->sizeModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->sizeModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

    public function changeStatus($request)
    {
        $dataInfo = $this->sizeModel->findOrFail($request->id);

        $dataInfo->update(['status' => $request->status]);

        return $dataInfo;
    }

    public function activeList()
    {
        return $this->sizeModel->whereNull('deleted_at')->where('status', 'Active')->get();
    }

}
