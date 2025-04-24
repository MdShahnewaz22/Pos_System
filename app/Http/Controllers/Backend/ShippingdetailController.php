<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingdetailRequest;
use App\Models\Shippingdetail;
use Illuminate\Support\Facades\DB;
use App\Services\ShippingdetailService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use App\Traits\SystemTrait;
use Exception;

class ShippingdetailController extends Controller
{
    use SystemTrait;

    protected $shippingdetailService;

    public function __construct(ShippingdetailService $shippingdetailService)
    {
        $this->shippingdetailService = $shippingdetailService;
    }

    public function index()
    {
        return Inertia::render(
            'Backend/Shippingdetail/Index',
            [
                'pageTitle' => fn() => 'Shipping detail List',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Shipping detail Manage'],
                    ['link' => route('backend.shippingdetail.index'), 'title' => 'Shipping detail List'],
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
            ['fieldName' => 'address', 'class' => 'text-center'],
            ['fieldName' => 'payment_status', 'class' => 'text-center'],
            ['fieldName' => 'subtotal', 'class' => 'text-center'],
        ];
    }
    private function getTableHeaders()
    {
        return [
            'Sl/No',
            'Full Name',
            'Address',
            'Payment Status',
            'Subtotal',
            'Action'
        ];
    }

    private function getDatas()
    {
        $query = $this->shippingdetailService->list();

        if (request()->filled('name'))
            $query->where('name', 'like', request()->name . '%');

        if (request()->filled('address'))
            $query->where('address', 'like', request()->address . '%');

        $datas = $query->paginate(request()->numOfData ?? 10)->withQueryString();

        $formatedDatas = $datas->map(function ($data, $index) {
            $customData = new \stdClass();
            $customData->index = $index + 1;

            $customData->name = $data->name;
            $customData->address = $data->address;
            $customData->payment_status = $data->payment_status;
            $customData->subtotal = $data->subtotal;
            $customData->hasLink = true;
            $customData->links = [

                //   [
                //     'linkClass' => 'semi-bold text-white statusChange ' . (($data->status == 'Active') ? "bg-gray-500" : "bg-green-500"),
                //     'link' => route('backend.shippingdetail.status.change', ['id' => $data->id, 'status' => $data->status == 'Active' ? 'Inactive' : 'Active']),
                //     'linkLabel' => getLinkLabel((($data->status == 'Active') ? "Inactive" : "Active"), null, null)
                // ],

                [
                    'linkClass' => 'bg-yellow-400 text-black semi-bold',
                    'link' => route('backend.shippingdetail.edit', $data->id),
                    'linkLabel' => getLinkLabel('Edit', null, null)
                ],
                [
                    'linkClass' => 'deleteButton bg-red-500 text-white semi-bold',
                    'link' => route('backend.shippingdetail.destroy', $data->id),
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
            'Backend/Shippingdetail/Form',
            [
                'pageTitle' => fn() => 'Shipping detail Create',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Shipping detail Manage'],
                    ['link' => route('backend.shippingdetail.create'), 'title' => 'Shipping detail Create'],
                ],
            ]
        );
    }


    public function store(ShippingdetailRequest $request)
    {

        DB::beginTransaction();
        try {

            $data = $request->validated();

            $dataInfo = $this->shippingdetailService->create($data);

            if ($dataInfo) {
                $message = 'Shippingdetail created successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'shippingdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To create Shippingdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {

            DB::rollBack();
            $this->storeSystemError('Backend', 'ShippingdetailController', 'store', substr($err->getMessage(), 0, 1000));

            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";

            return redirect()
                ->back()
                ->with('errorMessage', $message);
        }
    }

    public function edit($id)
    {
        $shippingdetail = $this->shippingdetailService->find($id);

        return Inertia::render(
            'Backend/Shippingdetail/Form',
            [
                'pageTitle' => fn() => 'Shippingdetail Edit',
                'breadcrumbs' => fn() => [
                    ['link' => null, 'title' => 'Shippingdetail Manage'],
                    ['link' => route('backend.shippingdetail.edit', $id), 'title' => 'Produt Edit'],
                ],
                'shippingdetail' => fn() => $shippingdetail,
                'id' => fn() => $id,
            ]
        );
    }

    public function update(ShippingdetailRequest $request, $id)
    {
        DB::beginTransaction();
        try {

            $data = $request->validated();
            $Shippingdetail = $this->shippingdetailService->find($id);


            $dataInfo = $this->shippingdetailService->update($data, $id);

            if ($dataInfo->save()) {
                $message = 'Shippingdetail updated successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'shippingdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To update Shippingdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Shippingdetailcontroller', 'update', substr($err->getMessage(), 0, 1000));
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

            if ($this->shippingdetailService->delete($id)) {
                $message = 'Shippingdetail deleted successfully';
                $this->storeAdminWorkLog($id, 'shippingdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To Delete Shippingdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'Shippingdetailcontroller', 'destroy', substr($err->getMessage(), 0, 1000));
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
            $dataInfo = $this->shippingdetailService->changeStatus(request());

            if ($dataInfo->wasChanged()) {
                $message = 'Shippingdetail ' . request()->status . ' Successfully';
                $this->storeAdminWorkLog($dataInfo->id, 'shippingdetails', $message);

                DB::commit();

                return redirect()
                    ->back()
                    ->with('successMessage', $message);
            } else {
                DB::rollBack();

                $message = "Failed To " . request()->status . " Shippingdetail.";
                return redirect()
                    ->back()
                    ->with('errorMessage', $message);
            }
        } catch (Exception $err) {
            DB::rollBack();
            $this->storeSystemError('Backend', 'ShippingdetailController', 'changeStatus', substr($err->getMessage(), 0, 1000));
            DB::commit();
            $message = "Server Errors Occur. Please Try Again.";
            return redirect()
                ->back()
                ->withErrors(['error' => $message]);
        }
    }
}
