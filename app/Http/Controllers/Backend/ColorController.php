<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Support\Facades\DB;
use App\Services\ColorService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class ColorController extends Controller
{
    use SystemTrait;

    protected $colorService;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Color/Index',
            [
                'pageTitle' => fn() => 'Color List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Color Manage'],
                    ['link' => route('backend.color.index'), 'title' => 'Color List'],
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
        $query = $this->colorService->list();

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
                    'link' => route('backend.color.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.color.destroy', $data->id),
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
            'Backend/Color/Form',
            [
                'pageTitle' => fn() => 'Color Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Color Manage'],
                    ['link' => route('backend.color.create'), 'title' => 'Color Create'],
                ],
            ]
        );
    }


    public function store(ColorRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            $dataInfo = $this->colorService->create($data);

            if ($dataInfo) {
                $message = 'Color created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'colors', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Color.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {

            DB::rollBack();
            $this->storeSystemError('Backend', 'ColorController', 'store', substr($err->getMessage(), 0, 1000));

            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";

            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $color = $this->colorService->find($id);

        return Inertia::render(
            'Backend/Color/Form',
            [
                'pageTitle' => fn() => 'Color Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Color Manage'],
                    ['link' => route('backend.color.edit', $id), 'title' => 'Produt Edit'],
                ],
                'color' => fn() => $color,
                'id' => fn() => $id,
            ]
        );
    }

    public function update(ColorRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $Color = $this->colorService->find($id);


            $dataInfo = $this->colorService->update($data, $id);

            if ($dataInfo->save()) {
                $message = 'Color updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'colors', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Color.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Colorcontroller', 'update', substr($err->getMessage(), 0, 1000));
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

            if ($this->colorService->delete($id)) {
                $message = 'Color deleted successfully';
                $this->storeAdminWorkLog($id, 'colors', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Color.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Colorcontroller', 'destroy', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    
}
