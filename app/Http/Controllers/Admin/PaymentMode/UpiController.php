<?php

namespace App\Http\Controllers\Admin\PaymentMode;

use App\Http\Controllers\Controller;
use App\Models\PaymentMode\Upi;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpiController extends Controller
{

    public function index()
    {
        try {
            return view('admin.payment_mode.upi');
        } catch (Exception $e) {
            return redirect('500')->with(['error' => $e->getMessage()]);;
        }
    }


    public function create()
    {
    }


    public function store(Request $request)
    {
        $upi = new Upi();
        $upi->user_id      = Auth::user()->_id;
        $upi->name         = $request->name;
        $upi->upi_id       = $request->upi_id;
        $upi->status       = (int)$request->status;

        if ($upi->save())
            return response(['status' => 'success', 'msg' => 'UPI Added Successfully!']);

        return response(['status' => 'error', 'msg' => 'UPI not Added Successfully!']);
    }

    public function edit(Upi $Upi)
    {

        try {
            die(json_encode($Upi));
        } catch (Exception $e) {
            return redirect('500');
        }
    }


    public function update(Request $request, Upi $Upi)
    {

        $upi = $Upi;
        $upi->name         = $request->name;
        $upi->upi_id       = $request->upi_id;
        $upi->status       = (int)$request->status;

        if ($upi->save())
            return response(['status' => 'success', 'msg' => 'UPI Updated Successfully!']);

        return response(['status' => 'error', 'msg' => 'UPI not Updated Successfully!']);
    }


    public function destroy($id)
    {
        try {
            $res = Upi::where('_id', $id)->delete();
            if ($res)
                return response(['status' => 'success', 'msg' => 'UPI Removed Successfully!']);

            return response(['status' => 'error', 'msg' => 'UPI not Removed!']);
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Something went wrong!!']);
        }
    }


    public function UpiStatus(Request $request)
    {

        try {
            $upi = Upi::find($request->id);
            $upi->status = (int)$request->status;
            $upi->save();
            if ($upi->status == 1)
                return response(['status' => 'success', 'msg' => 'This UPI is Active!', 'val' => $upi->status]);

            return response(['status' => 'success', 'msg' => 'This UPI is Inactive!', 'val' => $upi->status]);
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Something went wrong!!']);
        }
    }


     public function allocateRetailer(Request $request)
    {
        try {
            $bank_id = $request->id;
            $Upi = Upi::select('retailer_ids')->find($bank_id);

            $retailers = User::select('_id','outlet_name','role')->whereIn('role', ['retailer','distributor'])->get();

            $checkbox  = '<table class="table table-sm">';
            $checkbox .= '<tr><th>Outlet Name</th><th>Outlet Type</th><th>Action</th></tr>';
            foreach ($retailers as $retailer) {
                $checked = (!empty($Upi->retailer_ids) && is_array($Upi->retailer_ids) && in_array($retailer->id,$Upi->retailer_ids))?"checked":"";

                $checkbox .= '<tr>';
                $checkbox .='<td>' . ucwords($retailer->outlet_name) . '</td>';
                $checkbox .='<td>'.ucwords($retailer->role).'</td>';
                $checkbox .='<td><input type="checkbox" value="' . $retailer->_id . '" name="retailers[]" '.$checked.'></td>';
                $checkbox .='</tr>';
            }
            $checkbox .= '</table>';

            die(json_encode($checkbox));
        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Something went wrong!!']);
        }
    }


    public function saveAllocateRetailer(Request $request)
    {
        try {
            $Upi = Upi::find($request->id);
            $Upi->retailer_ids = $request->retailers;
            if ($Upi->save())
                return response(['status' => 'success', 'msg' => 'Bank Account Allocated Successfully!']);

        } catch (Exception $e) {
            return response(['status' => 'error', 'msg' => 'Something went wrong!!']);
        }
    }



    public function ajaxList(Request $request)
    {

        $draw = $request->draw;
        $start = $request->start;
        $length = $request->length;
        $search_arr = $request->search;
        $searchValue = $search_arr['value'];

        // count all data
        $totalRecords = Upi::AllCount();

        if (!empty($searchValue)) {
            // count all data
            $totalRecordswithFilter = Upi::LikeColumn($searchValue);
            $data = Upi::GetResult($searchValue);
        } else {
            // get per page data
            $totalRecordswithFilter = $totalRecords;
            $data = Upi::offset($start)->limit($length)->orderBy('created', 'DESC')->get();
        }
        $dataArr = [];
        $i = 1;

        foreach ($data as $val) {
            $action = '<a href="javascript:void(0);" class="text-warning allocate-retailer" data-toggle="tooltip" data-placement="bottom" title="Edit" bank_account_id="' . $val->_id . '"><i class="far fa-eye"></i></a>&nbsp;&nbsp;';
            $action .= '<a href="javascript:void(0);" class="text-info edit_upi_id" data-toggle="tooltip" data-placement="bottom" title="Edit" upi_id_id="' . $val->_id . '"><i class="far fa-edit"></i></a>&nbsp;&nbsp;';
            //$action .= '<a href="javascript:void(0);" class="text-danger remove_upi_id"  data-toggle="tooltip" data-placement="bottom" title="Remove" upi_id_id="' . $val->_id . '"><i class="fas fa-trash"></i></a>';
            if ($val->status == 1) {
                $status = ' <a href="javascript:void(0);"><span class="badge badge-success activeVer" id="active_' . $val->_id . '" _id="' . $val->_id . '" val="0">Active</span></a>';
            } else {
                $status = ' <a href="javascript:void(0)"><span class="badge badge-danger activeVer" id="active_' . $val->_id . '" _id="' . $val->_id . '" val="1">Inactive</span></a>';
            }
            $dataArr[] = [
                'sl_no'             => $i,
                'name'              => ucwords($val->name),
                'upi_id'           => $val->upi_id,
                'created_date'      => date('Y-m-d', $val->created),
                'status'            => $status,
                'action'            => $action
            ];
            $i++;
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" =>  $totalRecordswithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $dataArr
        );
        echo json_encode($response);
        exit;
    }
}
