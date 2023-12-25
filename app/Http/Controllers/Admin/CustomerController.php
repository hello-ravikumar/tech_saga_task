<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::orderBy('id','DESC')->get();
        return view('admin.customer.index',['customers' => $customers]);
    }
    
    public function getCutomer($id) {

        try {
            $customer = User::find($id);
            $html = view('admin.customer.modal-data',['customer' => $customer])->render();
            return response()->json([
                'status' => true,
                'message' => 'Customer recieved successfully',
                'data' =>  $customer,
                'fromUri' => route('admin.customer.status-update', $customer->id),
                'html' => $html
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function updateStatus(Request $request, $id) {
        try {
            $customer = User::find($id);
            if($customer) {
                $customer->verification = $request->verification;
                $customer->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Customer verification '.$customer->verification.' successfully',
                    'data' =>  $customer,
                ], 200);

            } else {
                return response()->json([
                    'status' => flase,
                    'message' => 'Customer not found',
                ]);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
