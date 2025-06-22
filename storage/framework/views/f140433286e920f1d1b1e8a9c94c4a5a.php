    <?php $__env->startSection('title'); ?>
        <?php echo app('translator')->get('system_settings.payment_method_settings'); ?>
    <?php $__env->stopSection(); ?>
<?php $__env->startSection('mainContent'); ?>
<?php $__env->startPush('css'); ?>
    <style>
        table.dataTable thead th {
            padding: 10px 30px !important;
        }

        table.dataTable tbody th, table.dataTable tbody td {
            padding: 20px 30px 20px 30px !important;
        }

        table.dataTable tfoot th, table.dataTable tfoot td {
            padding: 10px 30px 6px 30px;
        }
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        .CustomPaymentMethod{
            padding: 5px 0px 0px 0px !important;
            border-top: 0px !important;
        }
        .link-wrod-wrap{
            word-wrap: break-word;
        }
        table tr td{
            min-width: 150px;
        }
    </style>
<?php $__env->stopPush(); ?>
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1><?php echo app('translator')->get('system_settings.payment_method_settings'); ?></h1>
            <div class="bc-pages">
                <a href="<?php echo e(route('dashboard')); ?>"><?php echo app('translator')->get('common.dashboard'); ?></a>
                <a href="#"><?php echo app('translator')->get('system_settings.system_settings'); ?></a>
                <a href="#"><?php echo app('translator')->get('system_settings.payment_method_settings'); ?></a>
            </div>
        </div>
    </div>
</section>
<section class="mb-40 student-details">
    <div class="container-fluid p-0">
        <div class="row pt-20">
            <div class="col-lg-3">
                <?php if(userPermission('is-active-payment')): ?>
                    <?php echo e(Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'is-active-payment'])); ?>

                <?php endif; ?>
                <div class="white-box">
                    <div class="main-title">
                        <h3 class="mb-15"><?php echo app('translator')->get('system_settings.select_a_payment_gateway'); ?>   </h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table">
                                <?php $__currentLoopData = $paymeny_gateway; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(moduleStatusCheck('RazorPay') == FALSE && $value->method =="RazorPay"): ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="CustomPaymentMethod">
                                            <div class="primary_input">
                                                <input type="checkbox" id="gateway_<?php echo e(@$value->method); ?>" class="common-checkbox class-checkbox" name="gateways[<?php echo e(@$value->id); ?>]"
                                                value="<?php echo e(@$value->id); ?>" <?php echo e(@$value->active_status == 1? 'checked':''); ?>>
                                                <label for="gateway_<?php echo e(@$value->method); ?>"><?php echo e(@$value->method); ?></label>
                                            </div>
                                        </td>
                                        <td class="CustomPaymentMethod"></td>
                                    </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>
                            <?php if($errors->has('gateways')): ?>
                                <span class="text-danger validate-textarea-checkbox" role="alert">
                                    <?php echo e($errors->first('gateways')); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php
                        $tooltip = "";
                        if(userPermission('is-active-payment')){ $tooltip = ""; }else{  $tooltip = "You have no permission to Update"; }
                    ?>
                    <div class="row mt-15">
                        <div class="col-lg-12 text-center">
                            <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Disabled For Demo "> <button class="primary-btn fix-gr-bg  demo_view" style="pointer-events: none;" type="button" ><?php echo app('translator')->get('common.update'); ?> </button></span>
                            <?php else: ?>
                                <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="<?php echo e(@$tooltip); ?>">
                                    <span class="ti-check"></span>
                                    <?php echo app('translator')->get('common.update'); ?>
                                </button>
                          <?php endif; ?>
                        </div>
                    </div>
                </div>
                    <?php echo e(Form::close()); ?>

            </div>

            <div class="col-lg-9">
                 <div class="white-box">
                    <div class="row px-3" style="gap: 20px">
                        <div class="main-title pt-10">
                            <h3><?php echo app('translator')->get('system_settings.gateway_setting'); ?></h3>
                        </div>
                        <ul class="nav nav-tabs justify-content-start justify-sm-content-end my-2" role="tablist">
                            <?php $__currentLoopData = $paymeny_gateway_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(moduleStatusCheck('RazorPay') == FALSE && $row->gateway_name =="RazorPay"): ?>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link
                                    <?php if(!empty(Session::get('gateway_name')) && !empty(Session::get('active_status'))): ?>
                                        <?php if(Session::get('gateway_name') == @$row->gateway_name && Session::get('active_status') == "active"): ?> active show
                                        <?php endif; ?>                               
                                    <?php else: ?>
                                        <?php if(@$row->gateway_name=='PayPal'): ?> active show <?php endif; ?>
                                    <?php endif; ?> "
                                     href="#<?php echo e(@$row->gateway_name); ?>" role="tab" data-toggle="tab"><?php echo e(@$row->gateway_name); ?></a>
                                </li>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                     </div>
                    <!-- Tab panes -->
    
                    <div class="tab-content">
                        <?php
                            $forServiceCharge = ['service_charge', 'charge'];
                        ?>
                        <?php $__currentLoopData = $paymeny_gateway_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div role="tabpanel"
                                class="tab-pane fade   
                                <?php if(!empty(Session::get('gateway_name')) && !empty(Session::get('active_status'))): ?>
                                <?php if(Session::get('gateway_name') == @$row->gateway_name && Session::get('active_status') == "active"): ?> active show
                                <?php endif; ?>                               
                            <?php else: ?>
                                <?php if(@$row->gateway_name=='PayPal'): ?> active show <?php endif; ?>
                            <?php endif; ?> "
                                "
                                id="<?php echo e(@$row->gateway_name); ?>">
                                <?php if(userPermission('update-payment-gateway')): ?>
                                    <form class="form-horizontal" action="<?php echo e(route('update-payment-gateway')); ?>"
                                        method="POST">
                                <?php endif; ?>
                                <?php echo csrf_field(); ?>
                                <div>
                                    <div class="">
                                        <input type="hidden" name="url" id="url" value="<?php echo e(URL::to('/')); ?>">
                                        <input type="hidden" name="gateway_name" id="gateway_<?php echo e(@$row->gateway_name); ?>"
                                            value="<?php echo e(@$row->gateway_name); ?>">
                                        <div class="row mb-15">
                                            <div class="col-md-12">
                                                <?php
                                                if(@$row->gateway_name=="PayPal")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_username','gateway_password','gateway_signature','gateway_client_id','gateway_mode','gateway_secret_key', 'service_charge', 'charge'];
                                                }
                                                else if(@$row->gateway_name=="Stripe")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_username','gateway_secret_key','gateway_publisher_key', 'service_charge', 'charge'];
                                                }
                                                else if(@$row->gateway_name=="Paystack")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_username','gateway_secret_key','gateway_publisher_key', 'service_charge', 'charge'];
                                                }
    
                                                else if(@$row->gateway_name=="Khalti")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_publisher_key','gateway_secret_key', 'service_charge', 'charge'];
                                                }
                                                else if(@$row->gateway_name=="Khalti")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_publisher_key','gateway_secret_key', 'service_charge', 'charge'];
                                                }
    
                                                else if(@$row->gateway_name=="RazorPay")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_secret_key','gateway_publisher_key', 'service_charge', 'charge'];
    
                                                }
                                                else if(@$row->gateway_name=="MercadoPago")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','mercado_pago_public_key','mercado_pago_acces_token', 'service_charge', 'charge'];
    
                                                }
    
                                                else if(@$row->gateway_name=="CcAveune")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','cca_merchant_id','cca_working_key', 'cca_access_code', 'service_charge', 'charge'];
    
                                                }
                                                else if(@$row->gateway_name=="PhonePe")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','phone_pay_merchant_id','phone_pay_salt_key','phone_pay_salt_index', 'gateway_mode', 'service_charge', 'charge'];
    
                                                }
    
                                                else if(@$row->gateway_name=="Xendit")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_secret_key','gateway_username', 'service_charge', 'charge'];
    
                                                }
    
                                                else if(@$row->gateway_name=="Raudhahpay")
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_password','gateway_username', 'service_charge', 'charge'];
    
                                                }
                                                else if(@$row->gateway_name=="ToyyibPay" &&  moduleStatusCheck('ToyyibPay') == TRUE)
                                                {
                                                    @$paymeny_gateway = ['gateway_name','gateway_mode','gateway_secret_key', 'service_charge', 'charge'];
                                                }
                                                  
                                                else if(@$row->gateway_name=="Bank"){
                                                    @$paymeny_gateway = ['gateway_name', 'bank_details'];
    
                                                }else if(@$row->gateway_name=="Cheque"){
                                                    @$paymeny_gateway = ['gateway_name','cheque_details'];
    
                                                }
                                                    if(@$row->gateway_name=="Stripe" || @$row->gateway_name=="Paystack" || @$row->gateway_name=="RazorPay" || @$row->gateway_name=="Xendit" || @$row->gateway_name=="Raudhahpay" || @$row->gateway_name=="PayPal" || @$row->gateway_name=="Khalti" || @$row->gateway_name=="MercadoPago" || @$row->gateway_name=="CcAveune" || @$row->gateway_name=="PhonePe" || @$row->gateway_name=="ToyyibPay"){
                                                    $count=0;
                                                    foreach ($paymeny_gateway as $key=>$input_field) {
                                                        if(@$row->gateway_name=="RazorPay"){
                                                            if($input_field == 'gateway_publisher_key'){
                                                                @$newStr = 'gateway_secret_key';
                                                            }
                                                            elseif($input_field == 'gateway_secret_key'){
                                                                @$newStr = 'gateway_publisher_key';
                                                            }
                                                            else{
                                                                @$newStr = 'gateway_publisher_key';
                                                            }
    
                                                        }else{
                                                            @$newStr = @$input_field;
                                                        }
    
                                                        @$label_name = str_replace('_', ' ', @$newStr);
                                                        @$value= @$row->$input_field; ?>
                                                <?php if(!in_array($input_field, $forServiceCharge)): ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-15">
                                                            <div class="primary_input">
                                                                <label><?php echo e(@$label_name); ?>

                                                                    <p class="text-lowercase d-inline-block">
                                                                        <?php
                                                                            if ($input_field == 'gateway_mode') {
                                                                                echo strtolower('(sandbox or live)');
                                                                            }
                                                                        ?>
                                                                    </p>
                                                                    <span></span>
                                                                </label>
                                                                <input
                                                                    class="primary_input_field form-control<?php echo e($errors->has($input_field) ? ' is-invalid' : ''); ?>"
                                                                    type="text" name="<?php echo e($input_field); ?>"
                                                                    id="gateway_<?php echo e($input_field); ?>" autocomplete="off"
                                                                    value="<?php echo e(isset($value) ? $value : ''); ?>"
                                                                    <?php if(@$count == 0): ?> readonly="" <?php endif; ?>>
                                                                
                                                                
                                                                <?php if($errors->has($input_field)): ?>
                                                                    <span class="text-danger" >
                                                                        <?php echo e($errors->first($input_field)); ?></strong>
                                                                    </span>
                                                                <?php endif; ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($input_field == 'service_charge'): ?>
                                                    <?php
                                                        $d_none = $row->service_charge == 0 ? 'd-none' : '';
                                                    ?>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <input type="checkbox"
                                                                id="service_charge_<?php echo e($row->gateway_name); ?>"
                                                                class="common-checkbox form-control<?php echo e(@$errors->has('service_charge') ? ' is-invalid' : ''); ?> service_charge"
                                                                name="service_charge" value="1"
                                                                data-gateway_name="<?php echo e($row->gateway_name); ?>"
                                                                <?php echo e($row->service_charge == 1 ? 'checked' : ''); ?>>
                                                            <label
                                                                for="service_charge_<?php echo e($row->gateway_name); ?>"><?php echo e(__('common.service_charge')); ?></label>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row <?php echo e($d_none); ?>" id="charge_type_<?php echo e($row->gateway_name); ?>">
                                                        <div class="col-lg-6 ">
                                                            <label for=""> </label>
                                                            <div class="d-flex radio-btn-flex mt-10">
    
                                                                <div class="mr-30">
                                                                    <input type="radio" name="charge_type"
                                                                        id="p_<?php echo e($row->gateway_name); ?>" value="P"
                                                                        class="common-radio relationButton type_<?php echo e($row->gateway_name); ?>"
                                                                        <?php echo e(old('charge_type', $row->charge_type ?? 'P') == 'P' ? 'checked' : ''); ?>>
                                                                    <label
                                                                        for="p_<?php echo e($row->gateway_name); ?>"><?php echo app('translator')->get('common.Percentage'); ?></label>
                                                                </div>
                                                                <div class="mr-30">
                                                                    <input type="radio" name="charge_type"
                                                                        id="f_<?php echo e($row->gateway_name); ?>" value="F"
                                                                        class="common-radio relationButton type_<?php echo e($row->gateway_name); ?>"
                                                                        <?php echo e($row->charge_type == 'F' ? 'checked' : ''); ?>>
                                                                    <label
                                                                        for="f_<?php echo e($row->gateway_name); ?>"><?php echo app('translator')->get('common.Flat'); ?></label>
                                                                </div>
                                                                
                                                            </div>
                                                            <?php if($errors->has('charge_type') && old('gateway_name') == $row->gateway_name): ?>
                                                                    <span class="text-danger d-block" >
                                                                        <?php echo e($errors->first('charge_type')); ?>

                                                                    </span>
                                                                <?php endif; ?>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="primary_input">
                                                                <input type="number"
                                                                    class="primary_input_field form-control chargeValue <?php echo e($errors->has('charge') ? ' is-invalid' : ''); ?>"
                                                                    type="text" name="charge" data-gateway_name="<?php echo e($row->gateway_name); ?>"
                                                                    id="charge_<?php echo e($row->gateway_name); ?>" autocomplete="off"
                                                                    value="<?php echo e($row->charge); ?>">
    
                                                                
                                                                <?php if($errors->has('charge')): ?>
                                                                    <span class="text-danger" >
                                                                        <?php echo e($errors->first('charge')); ?>

                                                                    </span>
                                                                <?php endif; ?>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php $count++; } ?>
                                                <?php  }elseif(@$row->gateway_name=="Bank"){?>
                                                <div class="col-lg-12">
                                                    <div class="row">
                                                        <div class="col-lg-4 no-gutters">
                                                            <div class="main-title">
                                                                <h3 class="mb-0"><?php echo app('translator')->get('system_settings.bank_account_list'); ?></h3>
                                                                <strong><?php echo app('translator')->get('common.note'); ?>:
                                                                </strong><small><?php echo app('translator')->get('system_settings.Available_for_students_and_parents'); ?></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="table-responsive">
                                                                <table id="noSearch" class="table shadow-none"
                                                                cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th><?php echo app('translator')->get('system_settings.value'); ?></th>
                                                                        <th><?php echo app('translator')->get('accounts.bank_name'); ?></th>
                                                                        <th><?php echo app('translator')->get('accounts.account_name'); ?></th>
                                                                        <th><?php echo app('translator')->get('accounts.account_number'); ?></th>
                                                                        <th><?php echo app('translator')->get('accounts.account_type'); ?></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $bank_accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank_account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <tr>
                                                                            <td>
                                                                                <div class="primary_input">
                                                                                    <input type="checkbox"
                                                                                        data-id="<?php echo e(@$bank_account->id); ?>"
                                                                                        id="bank<?php echo e(@$bank_account->id); ?>"
                                                                                        class="common-checkbox class-checkbox accountStatus"
                                                                                        name="account_status"
                                                                                        value="<?php echo e(@$bank_account->id); ?>"
                                                                                        <?php echo e(@$bank_account->active_status == 1 ? 'checked' : ''); ?>>
                                                                                    <label
                                                                                        for="bank<?php echo e(@$bank_account->id); ?>"><?php echo e(@$value->method); ?></label>
                                                                                </div>
                                                                            </td>
                                                                            <td><?php echo e(@$bank_account->bank_name); ?></td>
                                                                            <td><?php echo e(@$bank_account->account_name); ?></td>
                                                                            <td><?php echo e(@$bank_account->account_number); ?></td>
                                                                            <td><?php echo e(@$bank_account->account_type); ?></td>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }elseif(@$row->gateway_name=="Cheque") {
                                                $count=0;
                                                    foreach ($paymeny_gateway as $input_field) {
                                                        @$newStr = @$input_field;
                                                        @$label_name = str_replace('_', ' ', @$newStr);
                                                        @$value= @$row->$input_field; ?>
                                                <?php if($count == 0): ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-15">
                                                            <div class="primary_input">
                                                                <label><?php echo e(@$label_name); ?> <span></span> </label>
                                                                <input
                                                                    class="primary_input_field form-control<?php echo e($errors->has($input_field) ? ' is-invalid' : ''); ?>"
                                                                    type="text" name="<?php echo e($input_field); ?>"
                                                                    id="gateway_<?php echo e($input_field); ?>" autocomplete="off"
                                                                    value="<?php echo e(isset($value) ? $value : ''); ?>"
                                                                    <?php if(@$count == 0): ?> readonly="" <?php endif; ?>>
                                                               
                                                                
                                                                <span class="modal_input_validation red_alert"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="row">
                                                        <div class="col-lg-12 ">
                                                            <label class="textarea-label"> <?php echo app('translator')->get('common' . '.' . $input_field); ?>
                                                                <span></span> </label>
                                                            <div class="primary_input sm2_mb_20">
                                                                <script src="https://cdn.ckeditor.com/4.25.0-lts/standard/ckeditor.js"></script>
                                                                <textarea class="primary_input_field article-ckeditor form-control" cols="0" rows="3"
                                                                    name="<?php echo e($input_field); ?>" id="article-ckeditor"><?php echo e(@$value); ?></textarea>
                                                                <script>
                                                                    CKEDITOR.replace("<?php echo $input_field; ?>");
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <?php $count++; }
                                              }
                                              ?>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row justify-content-center">
                                                    <?php if(!empty(@$row->logo)): ?>
                                                        <img class="logo" src="<?php echo e(URL::asset(@$row->logo)); ?>"
                                                            style="width: auto; height: 100px; ">
                                                    <?php endif; ?>
                                                </div>
                                                <div class="row justify-content-center">
                                                    <?php if(session()->has('message-success')): ?>
                                                        <p class=" text-success">
                                                            <?php echo e(session()->get('message-success')); ?>

                                                        </p>
                                                    <?php elseif(session()->has('message-danger')): ?>
                                                        <p class=" text-danger">
                                                            <?php echo e(session()->get('message-danger')); ?>

                                                        </p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                        $tooltip = '';
                                        if (userPermission('update-payment-gateway')) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    ?>
                                    <?php if(@$row->gateway_name != 'Bank'): ?>
                                        <?php if(@$row->gateway_name == 'Paystack'): ?>
                                            <strong class="main-title"> N.B: Please Set This url <a class="disabled link-wrod-wrap"
                                                    href=" <?php echo e(route('payment.success','Paystack')); ?>" disable>
                                                    <?php if(directFees() ||  generalSetting()->fees_status ): ?>
                                                    <?php echo e(route('payment.success','Paystack')); ?> 
                                                    <?php else: ?>
                                                        <?php echo e(route('handleGatewayCallback')); ?> 
                                                    <?php endif; ?>
                                                </a> As Paystack Callback Url </strong>
                                        <?php endif; ?>
    
                                        <?php if(@$row->gateway_name == 'Raudhahpay'): ?>
                                            <strong class="main-title"> N.B: Please Set This url <a class="disabled link-wrod-wrap"
                                                    href="<?php echo e(url('raudhahpay/payment_success_callback')); ?>"
                                                    disable><?php echo e(url('raudhahpay/payment_success_callback')); ?></a> As
                                                Raudhahpay WebHook Url </strong>
                                        <?php endif; ?>
    
                                        <div class="row mt-40">
                                            <div class="col-lg-12 text-center">
                                                <?php if(Illuminate\Support\Facades\Config::get('app.app_sync')): ?>
                                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip"
                                                        title="Disabled For Demo "> <button
                                                            class="primary-btn fix-gr-bg  demo_view"
                                                            style="pointer-events: none;"
                                                            type="button"><?php echo app('translator')->get('common.update'); ?> </button></span>
                                                <?php else: ?>
                                                    <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                        title="<?php echo e(@$tooltip); ?>">
                                                        <span class="ti-check"></span>
                                                        <?php echo app('translator')->get('common.update'); ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
    
                                </div>
                                </form>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        $(document).on('change','.accountStatus',function (){
            let account_id = $(this).data('id');
            let account_status =0;
            if ($(this).is(':checked'))
            {
                account_status = 1;
            }
            $.ajax({
                url : "<?php echo e(route('bank-status')); ?>",
                method : "POST",
                data : {
                    account_id : account_id,
                    account_status : account_status,
                },
                success : function (result){
                    toastr.success('Operation successful', 'Successful', {
                        timeOut: 5000
                    })
                }
            })
        })
        $(document).on('click', '.service_charge', function(){
            let gateway_name = $(this).data('gateway_name');
            let service_charge = $(this).data('gateway_name');
            let status = $(this).is(':checked') ? 1 : 0;
            let type = $('.type_'+gateway_name).val();
            if(status == 1) {
                $('#charge_type_'+gateway_name).removeClass('d-none');        
            }else {
                $('#charge_type_'+gateway_name).addClass('d-none');
            }            
        });  
        $(document).on('keyup', '.chargeValue', function(){
            let gateway_name = $(this).data('gateway_name');
            let className = $('.type_'+gateway_name);
            let type = $("input.type_"+gateway_name+"[name='charge_type']:checked").val();
            console.log(type);
            let charge = $(this).val();
            console.log(typeof charge);            
            if (type == 'P' && charge > 100) {
                toastr.error("Value Can't be more than 100 ");
                $(this).val('');
            }
        });                                                                                                                                                                                                                                              
    </script>                                              
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('backEnd.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\classai\resources\views/backEnd/systemSettings/paymentMethodSettings.blade.php ENDPATH**/ ?>