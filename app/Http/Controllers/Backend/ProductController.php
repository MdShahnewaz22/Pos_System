<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class ProductController extends Controller
{
    use SystemTrait;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Product/Index',
            [
                'pageTitle' => fn() => 'Product List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Product Manage'],
                    ['link' => route('backend.product.index'), 'title' => 'Product List'],
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
            ['fieldName' => 'sku', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Name',
            'sku',
            'Action'
        ];
    }

    private function getDatas()
    {
        $query = $this->productService->list();

        if (request()->filled('name'))
            $query->where('name', 'like', request()->name . '%');

        if (request()->filled('sku'))
            $query->where('sku', 'like', request()->sku . '%');

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;

            $customData->name = $data->name;
            $customData->sku = $data->sku;
            $customData->hasLink = true;
            $customData->links = [

                //   [
                //     'linkClass' => 'semi-bold text-white statusChange ' . (($data->status == 'Active') ? "bg-gray-500" : "bg-green-500"),
                //     'link' => route('backend.product.status.change', ['id' => $data->id, 'status' => $data->status == 'Active' ? 'Inactive' : 'Active']),
                //     'linkLabel' => getLinkLabel((($data->status == 'Active') ? "Inactive" : "Active"), null, null)
                // ],

                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.product.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.product.destroy', $data->id),
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
            'Backend/Product/Form',
            [
                'pageTitle' => fn() => 'Product Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Product Manage'],
                    ['link' => route('backend.product.create'), 'title' => 'Product Create'],
                ],
            ]
        );
    }


    public function store(ProductRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            $dataInfo = $this->productService->create($data);

            if ($dataInfo) {
                $message = 'Product created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'products', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Product.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {

            DB::rollBack();
            $this->storeSystemError('Backend', 'ProductController', 'store', substr($err->getMessage(), 0, 1000));

            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";

            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $product = $this->productService->find($id);

        return Inertia::render(
            'Backend/Product/Form',
            [
                'pageTitle' => fn() => 'Product Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Product Manage'],
                    ['link' => route('backend.product.edit', $id), 'title' => 'Produt Edit'],
                ],
                'product' => fn() => $product,
                'id' => fn() => $id,
            ]
        );
    }

    public function update(ProductRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $Product = $this->productService->find($id);


            $dataInfo = $this->productService->update($data, $id);

            if ($dataInfo->save()) {
                $message = 'Product updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'products', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Product.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Productcontroller', 'update', substr($err->getMessage(), 0, 1000));
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

            if ($this->productService->delete($id)) {
                $message = 'Product deleted successfully';
                $this->storeAdminWorkLog($id, 'products', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Product.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Productcontroller', 'destroy', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->productService->changeStatus(request());

            if ($dataInfo->wasChanged()) {
                $message = 'Product ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'products', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " Product.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'ProductController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->withErrors(['error' => $message]);
        }
    }
}
