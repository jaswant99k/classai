<?php

namespace Modules\RazorPay\Http\Controllers;

use App\User;
use App\SmFeesAssign;
use App\SmFeesMaster;
use App\SmFeesPayment;
use App\SmParent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\SmPaymentGatewaySetting;
use App\SmStudent;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Razorpay\Api\Api;

class RazorPayController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('PM');

    }


    public function index()
    {
        $module = 'RazorPay';
        if (User::checkPermission($module) != 100) {
            Toastr::error('Please verify your ' . $module . ' Module', 'Failed');
            return redirect()->route('Moduleverify', $module);
        }
        try {
            return view('razorpay::index');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function about()
    {
        try {
            $data = \App\InfixModuleManager::where('name', 'RazorPay')->first();
            return view('razorpay::about', compact('data'));
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function create()
    {
        return view('razorpay::create');
    }

    public function show($id)
    {
        return view('razorpay::show');
    }

    public function edit($id)
    {
        return view('razorpay::edit');
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function pay()
    {
        return view('razorpay::abc');
    }

    public function dopayment(Request $request)
    {
        $input = $request->all();

        $fees_payment = new SmFeesPayment();
        $fees_payment->student_id = $request->student_id;
        $fees_payment->fees_type_id = $request->fees_type_id;

        $fees_payment->discount_amount = 0;
        $fees_payment->fine = 0;
        $fees_payment->amount = $request->amount / 100;
        $fees_payment->payment_date = date('Y-m-d', strtotime(date('Y-m-d')));
        $fees_payment->payment_mode = 'RP';
        $result = $fees_payment->save();

        $get_master_id=SmFeesMaster::join('sm_fees_assigns','sm_fees_assigns.fees_master_id','=','sm_fees_masters.id')
        ->where('sm_fees_masters.fees_type_id',$request->fees_type_id)
        ->where('sm_fees_assigns.student_id',$request->student_id)->first();

        $fees_assign=SmFeesAssign::where('fees_master_id',$get_master_id->fees_master_id)->first();
        $fees_assign->fees_amount-=$request->amount;
        $fees_assign->save();
        print_r($input);
        exit;
    }

    public function getOrderId(Request $request){
        try{
            $razorPayDetails = SmPaymentGatewaySetting::where('school_id',auth()->user()->school_id)
                                ->select('gateway_publisher_key','gateway_secret_key')
                                ->where('gateway_name', '=', 'RazorPay')
                                ->first();

            $role = User::find($request->user_id);
            if($role->role_id==2){
                $user = SmStudent::where('user_id',$request->user_id)->first();
            }elseif($role->role_id==3){
                $user = SmParent::where('user_id',$request->user_id)->first();
            }
            $orderData = [
                'receipt'  => $user->full_name,
                'amount'   => $request->razorAmount,
                'currency' => generalSetting()->currency,
            ];

            $api = new Api($razorPayDetails->gateway_publisher_key, $razorPayDetails->gateway_secret_key);
            $razorpayOrder = $api->order->create($orderData)->toArray();
            return response()->json($razorpayOrder+['user'=>$user,'secretKey'=>$razorPayDetails,'role'=>$role]);
        }catch(\Exception $e){
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
