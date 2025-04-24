<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use App\Services\UnitService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class UnitController extends Controller
{
    use SystemTrait;

    protected $unitService;

    public function __construct(UnitService $unitService)
    {
        $this->unitService = $unitService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Unit/Index',
            [
                'pageTitle' => fn() => 'Unit List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Unit Manage'],
                    ['link' => route('backend.unit.index'), 'title' => 'Unit List'],
                ],
                'tableHeaders' => fn() => $this->getTableHeaders(),
                'dataFields' => fn() => $this->getDataFields(),
                'datas' => fn() => $this->getDatas(),
            ]
        );
    }

    private function getDataFields()
    {
        return [
            ['fieldName' => 'index', 'class' => 'text-center'],
            ['fieldName' => 'name', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Name',
            'Action'
        ];
    }

    private function getDatas()
    {
        $query = $this->unitService->list();

        if (request()->filled('name'))
            $query->where('name', 'like', request()->name . '%');

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;

            $customData->name = $data->name;
            $customData->hasLink = true;
            $customData->links = [

                

                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.unit.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.unit.destroy', $data->id),
                    'linkLabel' => getLinkLabel('Delete', null, null)
                ]
            ];
            return $customData;
        });

        return regeneratePagination($formatedDatas, $datas->total(), $datas->perPage(), $datas->currentPage());
    }

    public function create()
    {
        return Inertia::render(
            'Backend/Unit/Form',
            [
                'pageTitle' => fn() => 'Unit Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Unit Manage'],
                    ['link' => route('backend.size.create'), 'title' => 'Size Create'],
                ],
            ]
        );
    }


    public function store(UnitRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            $dataInfo = $this->unitService->create($data);

            if ($dataInfo) {
                $message = 'Unit created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'units', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Unit.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {

            DB::rollBack();
            $this->storeSystemError('Backend', 'UnitController', 'store', substr($err->getMessage(), 0, 1000));

            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";

            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $unit = $this->unitService->find($id);

        return Inertia::render(
            'Backend/Unit/Form',
            [
                'pageTitle' => fn() => 'Unit Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Unit Manage'],
                    ['link' => route('backend.unit.edit', $id), 'title' => 'Unit Edit'],
                ],
                'unit' => fn() => $unit,
                'id' => fn() => $id,
            ]
        );
    }

    public function update(UnitRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $unit = $this->unitService->find($id);


            $dataInfo = $this->unitService->update($data, $id);

            if ($dataInfo->save()) {
                $message = 'Unit updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'units', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Unit.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Unitcontroller', 'update', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function destroy($id)
    {

        DB::beginTransaction();

        try {

            if ($this->unitService->delete($id)) {
                $message = 'Unit deleted successfully';
                $this->storeAdminWorkLog($id, 'units', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Unit.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Unitcontroller', 'destroy', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    
}
