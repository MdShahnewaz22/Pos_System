<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use App\Services\SizeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class SizeController extends Controller
{
    use SystemTrait;

    protected $sizeService;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Size/Index',
            [
                'pageTitle' => fn() => 'Size List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Size Manage'],
                    ['link' => route('backend.size.index'), 'title' => 'Size List'],
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
        $query = $this->sizeService->list();

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
                    'link' => route('backend.size.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.size.destroy', $data->id),
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
            'Backend/Size/Form',
            [
                'pageTitle' => fn() => 'Size Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Size Manage'],
                    ['link' => route('backend.size.create'), 'title' => 'Size Create'],
                ],
            ]
        );
    }


    public function store(SizeRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            $dataInfo = $this->sizeService->create($data);

            if ($dataInfo) {
                $message = 'Size created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'sizes', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Size.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {

            DB::rollBack();
            $this->storeSystemError('Backend', 'SizeController', 'store', substr($err->getMessage(), 0, 1000));

            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";

            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $size = $this->sizeService->find($id);

        return Inertia::render(
            'Backend/Size/Form',
            [
                'pageTitle' => fn() => 'Size Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Size Manage'],
                    ['link' => route('backend.size.edit', $id), 'title' => 'Size Edit'],
                ],
                'size' => fn() => $size,
                'id' => fn() => $id,
            ]
        );
    }

    public function update(SizeRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $size = $this->sizeService->find($id);


            $dataInfo = $this->sizeService->update($data, $id);

            if ($dataInfo->save()) {
                $message = 'Size updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'sizes', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Size.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Sizecontroller', 'update', substr($err->getMessage(), 0, 1000));
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

            if ($this->sizeService->delete($id)) {
                $message = 'Size deleted successfully';
                $this->storeAdminWorkLog($id, 'sizes', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Size.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Sizecontroller', 'destroy', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

}
