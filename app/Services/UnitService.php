<?php

namespace App\Services;

use App\Models\Unit;

class UnitService
{
    protected $unitModel;

    public function __construct(Unit $unitModel)
    {
        $this->unitModel = $unitModel;
    }

    public function list()
    {
        return $this->unitModel->whereNull('deleted_at');
    }

    public function all()
    {
        return $this->unitModel->whereNull('deleted_at')->get();
    }

    public function find($id)
    {
        return $this->unitModel->find($id);
    }

    public function create(array $data)
    {
        return $this->unitModel->create($data);
    }

    public function update(array $data, $id)
    {
        $dataInfo = $this->unitModel->findOrFail($id);

        $dataInfo->update($data);

        return $dataInfo;
    }

    public function delete($id)
    {
        $dataInfo = $this->unitModel->find($id);

        if (!empty($dataInfo)) {

            $dataInfo->deleted_at = date('Y-m-d H:i:s');

            $dataInfo->status = 'Deleted';

            return ($dataInfo->save());
        }
        return false;
    }

}
