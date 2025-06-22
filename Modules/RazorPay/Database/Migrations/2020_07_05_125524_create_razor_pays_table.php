<?php

use App\SmSChool;
use App\SmLanguagePhrase;
use App\SmPaymentMethhod;
use App\SmGeneralSettings;
use App\SmPaymentGatewaySetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRazorPaysTable extends Migration

{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        try {

            //if saas module enable /
            if (moduleStatusCheck('Saas') == TRUE) {
                $schools = SmSchool::all();
                foreach ($schools as $school) {
                    $is_method = SmPaymentMethhod::where('method', 'RazorPay')->where('school_id', $school->id)->first();
                    if (empty($is_method)) {
                        $is_method = new SmPaymentMethhod();
                    }
                    $is_method->method = 'RazorPay';
                    $is_method->type = 'Module';
                    $is_method->active_status = 1;
                    $is_method->school_id = $school->id;
                    $is_method->created_at = date('Y-m-d h:i:s');
                    $is_method->save();


                    $is_setting = SmPaymentGatewaySetting::where('gateway_name', 'RazorPay')->where('school_id', $school->id)->first();
                    if ($is_setting == "") {
                        $is_method = new SmPaymentGatewaySetting();
                        $is_method->gateway_name = 'RazorPay';
                        $is_method->gateway_username = 'demo@gmail.com';
                        $is_method->gateway_password = '123456';
                        $is_method->school_id = $school->id;
                        $is_method->created_at = date('Y-m-d h:i:s');
                        $is_method->save();
                    }
                }
            } else {

                $is_method = SmPaymentMethhod::where('method', 'RazorPay')->where('school_id', Auth::user()->school_id)->first();
                if (empty($is_method)) {
                    $is_method = new SmPaymentMethhod();
                }
                $is_method->method = 'RazorPay';
                $is_method->type = 'Module';
                $is_method->active_status = 1;
                $is_method->created_at = date('Y-m-d h:i:s');
                $is_method->save();

                $is_setting = SmPaymentGatewaySetting::where('gateway_name', 'RazorPay')->where('school_id', Auth::user()->school_id)->first();
                if ($is_setting == "") {
                    $is_method = new SmPaymentGatewaySetting();
                }
                $is_method->gateway_name = 'RazorPay';
                $is_method->gateway_username = 'demo@gmail.com';
                $is_method->gateway_password = '123456';
                $is_method->created_at = date('Y-m-d h:i:s');
                $is_method->save();
            }



            $d = [
                [NULL, 'pay', 'Pay', '', '', '']
            ];


            foreach ($d as $row) {
                $s = SmLanguagePhrase::where('default_phrases', trim($row[1]))->first();
                if (empty($s)) {
                    $s = new SmLanguagePhrase();
                }
                $s->modules = $row[0];
                $s->default_phrases = trim($row[1]);
                $s->en = trim($row[2]);
                $s->es = trim($row[3]);
                $s->bn = trim($row[4]);
                $s->fr = trim($row[5]);
                $s->save();
            }
        } catch (\Throwable $th) {
            Log::info($th->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('razor_pays');
    }
}
