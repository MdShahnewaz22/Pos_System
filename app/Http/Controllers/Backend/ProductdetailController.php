<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductdetailRequest;
use App\Models\Productdetail;
use Illuminate\Support\Facades\DB;
use App\Services\ProductdetailService;
use App\Services\ProductService;
use App\Services\UnitService;
use App\Services\ColorService;
use App\Services\SizeService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class ProductdetailController extends Controller
{
    use SystemTrait;

    protected $productdetailService,$productService,$unitService,$colorService,$sizeService;

    public function __construct(ProductdetailService $productdetailService,ProductService $productService,UnitService $unitService,ColorService $colorService,SizeService $sizeService)
    {
        $this->productdetailService = $productdetailService;
        $this->productService = $productService;
        $this->unitService = $unitService;
        $this->colorService = $colorService;
        $this->sizeService = $sizeService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Productdetail/Index',
            [
                'pageTitle' => fn() => 'Productdetail List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Productdetail Manage'],
                    ['link' => route('backend.productdetail.index'), 'title' => 'Productdetail List'],
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
            ['fieldName' => 'product_id', 'class' => 'text-center'],
            ['fieldName' => 'unit_id', 'class' => 'text-center'],
            ['fieldName' => 'unit_value', 'class' => 'text-center'],
            ['fieldName' => 'color_id', 'class' => 'text-center'],
            ['fieldName' => 'size_id', 'class' => 'text-center'],
            ['fieldName' => 'selling_price', 'class' => 'text-center'],
            ['fieldName' => 'purchase_price', 'class' => 'text-center'],
            ['fieldName' => 'tax', 'class' => 'text-center'],
            ['fieldName' => 'discount', 'class' => 'text-center'],
            ['fieldName' => 'image', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Product Name',
            'Unit Name',
            'Unit Value',
            'Color Name',
            'Size Name',
            'Selling Price',
            'Purchase Price',
            'Tax',
            'Discount',
            'Image',
            'Action'
        ];
    }

    private function getDatas()
    {
        $query = $this->productdetailService->list();

        if (request()->filled('name'))
            $query->where('name', 'like', request()->name . '%');

            if (request()->filled('image'))
            $query->where('image', 'like', request()->image . '%');

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;

         
            $customData->product_id = $data->product->name;
            $customData->unit_id = $data->unit->name;
            $customData->unit_value = $data->unit_value;
            $customData->color_id = $data->color->name;
            $customData->size_id = $data->size->name;
            $customData->selling_price = $data->selling_price;
            $customData->purchase_price = $data->purchase_price;
            $customData->tax = $data->tax;
            $customData->discount = $data->discount;
            // $customData->image = $data->image;
            $customData->image = '<img src="' . $data->image . '" height="60" width="70"/>';
            $customData->hasLink = true;
            $customData->links = [

                //   [
                //     'linkClass' => 'semi-bold text-white statusChange ' . (($data->status == 'Active') ? "bg-gray-500" : "bg-green-500"),
                //     'link' => route('backend.productdetail.status.change', ['id' => $data->id, 'status' => $data->status == 'Active' ? 'Inactive' : 'Active']),
                //     'linkLabel' => getLinkLabel((($data->status == 'Active') ? "Inactive" : "Active"), null, null)
                // ],

                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.productdetail.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.productdetail.destroy', $data->id),
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
            'Backend/Productdetail/Form',
            [
                'pageTitle' => fn() => 'Productdetail Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Productdetail Manage'],
                    ['link' => route('backend.productdetail.create'), 'title' => 'Productdetail Create'],
                ],
                'products' => fn() => $this->productService->all(),
                'units' => fn() => $this->unitService->all(),
                'colors' => fn() => $this->colorService->all(),
                'sizes' => fn() => $this->sizeService->all(),
            ]
        );
    }


    public function store(ProductdetailRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            if ($request->hasFile('image'))
            $data['image'] = $this->imageUpload($request->file('image'), 'productdetail');

            $dataInfo = $this->productdetailService->create($data);

            if ($dataInfo) {
                $message = 'Productdetail created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'productdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Productdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {

            DB::rollBack();
            $this->storeSystemError('Backend', 'ProductdetailController', 'store', substr($err->getMessage(), 0, 1000));

            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";

            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $productdetail = $this->productdetailService->find($id);

        return Inertia::render(
            'Backend/Productdetail/Form',
            [
                'pageTitle' => fn() => 'Productdetail Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Productdetail Manage'],
                    ['link' => route('backend.productdetail.edit', $id), 'title' => 'Productdetail Edit'],
                ],
                'productdetail' => fn() => $productdetail,
                'id' => fn() => $id,

                'products' => fn() => $this->productService->all(),
                'units' => fn() => $this->unitService->all(),
                'colors' => fn() => $this->colorService->all(),
                'sizes' => fn() => $this->sizeService->all(),
            ]
        );
    }

    public function update(ProductdetailRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();

            if ($request->hasFile('image'))
            $data['image'] = $this->imageUpload($request->file('image'), 'productdetails');
        
            $productdetail = $this->productdetailService->find($id);


            $dataInfo = $this->productdetailService->update($data, $id);

            if ($dataInfo->save()) {
                $message = 'Productdetail updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'productdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update productdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Productdetailcontroller', 'update', substr($err->getMessage(), 0, 1000));
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

            if ($this->productdetailService->delete($id)) {
                $message = 'productdetail deleted successfully';
                $this->storeAdminWorkLog($id, 'productdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete productdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Productdetailcontroller', 'destroy', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function changeStatus()
    {
        DB::beginTransaction();

        try {
            $dataInfo = $this->productdetailService->changeStatus(request());

            if ($dataInfo->wasChanged()) {
                $message = 'Productdetail ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'productdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " Productdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'ProductdetailController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->withErrors(['error' => $message]);
        }
    }
}
