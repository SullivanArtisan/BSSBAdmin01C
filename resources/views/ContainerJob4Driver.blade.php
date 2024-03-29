<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ContainerJob4Driver</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<?php
use App\Helper\MyHelper;
use App\Models\Container;
use App\Models\Booking;
use App\Models\Movement;
use App\Models\Driver;
use App\Models\container_completed;
use App\Http\Controllers\ContainerController;

    $driverId = "";
    $cntnrId = "";
    $driverName = "";
    $cntnrName = "";
    $complete = "";
    if (isset($_GET['driverId'])) {
        $driverId = $_GET['driverId'];
        $driver = Driver::where('id', $driverId)->first();
        $driverName = $driver->dvr_name;
    }

    if (isset($_GET['cntnrId'])) {
        $cntnrId = $_GET['cntnrId'];
        $container = Container::where('id', $cntnrId)->first();
        $booking = Booking::where('bk_job_no', $container->cntnr_job_no)->first();
        $containerCompleted = container_completed::where('ccntnr_id', $cntnrId)->first();
        $cntnrName = $container->cntnr_name;

        if (isset($_GET['driverNote'])) {
            $container->cntnr_driver_notes = $container->cntnr_driver_notes."\r\n".$_GET['driverNote'];
            $container->save();
        }
    }

    // The purpose of using the 'container_completed' table is to simulate PKCS's 3rd-party-software-company,
    // who provides the communication-bridge-function between PKCS's DB server and all drivers' cell-phone application.
    if (isset($_GET['complete'])) {
        if ($containerCompleted == null) {
            if ($container->cntnr_status != MyHelper::CntnrCompletedStaus()) {
                MyHelper::LogStaffActionResult($driverId, 'Driver just completed container '.$container->cntnr_name.' for job '.$booking->id, '');
                $finishedJob = new container_completed;
                $finishedJob->ccntnr_id = $cntnrId;
                $finishedJob->ccntnr_name   = $container->cntnr_name;
                $finishedJob->ccntnr_status = $container->cntnr_status;
                $finishedJob->ccntnr_job_id = $booking->id;
                $finishedJob->ccntnr_dvr_id = $driverId;
                $finishedJob->ccntnr_finished_on = date("Y-m-d H:i:s");
                $finishedJob->ccntnr_received = 'N';
                $finishedJob->ccntnr_cost = $container->cntnr_cost;
                $finishedJob->ccntnr_surcharges = $container->cntnr_surcharges;
                $finishedJob->ccntnr_discount = $container->cntnr_discount;
                $finishedJob->ccntnr_tax = $container->cntnr_tax;
                $finishedJob->ccntnr_total = $container->cntnr_total;
                $finishedJob->ccntnr_net = $container->cntnr_net;
                $finishedJob->ccntnr_paid = $container->cntnr_paid;
                $finishedJob->ccntnr_cstm_account_name = $container->cntnr_cstm_account_name;
                $finishedJob->ccntnr_cntnr_completed_on = $finishedJob->ccntnr_finished_on;
                $finishedJob->ccntnr_size = $container->cntnr_size;
                $finishedJob->ccntnr_goods_desc = $container->cntnr_goods_desc;
                $finishedJob->ccntnr_ssl_release_date = $container->cntnr_ssl_release_date;
                $finishedJob->ccntnr_cstm_order_no = $container->cntnr_cstm_order_no;
                $finishedJob->ccntnr_cstm_release_date = $container->cntnr_cstm_release_date;
                $finishedJob->ccntnr_cstm_release_time = $container->cntnr_cstm_release_time;
                $finishedJob->ccntnr_trmnl_lfd = $container->cntnr_trmnl_lfd;
                $finishedJob->ccntnr_ssl_lfd = $container->cntnr_ssl_lfd;
                $finishedJob->ccntnr_mt_lfd = $container->cntnr_mt_lfd;
                $finishedJob->ccntnr_mt_release_no = $container->cntnr_mt_release_no;
                $finishedJob->ccntnr_empty_return_trmnl = $container->cntnr_empty_return_trmnl;
                $finishedJob->ccntnr_ssl = $container->cntnr_ssl;
                $finishedJob->ccntnr_type = $container->cntnr_type;
                $finishedJob->ccntnr_length = $container->cntnr_length;
                $finishedJob->ccntnr_max_load = $container->cntnr_max_load;
                $finishedJob->ccntnr_max_weight = $container->cntnr_max_weight;
                $finishedJob->ccntnr_tare_weight = $container->cntnr_tare_weight;
                $finishedJob->ccntnr_seal_no = $container->cntnr_seal_no;
                $finishedJob->ccntnr_dvr_no = $container->cntnr_dvr_no;
                $finishedJob->ccntnr_pwr_unit_no_1 = $container->cntnr_pwr_unit_no_1;
                $finishedJob->ccntnr_pwr_unit_no_2 = $container->ccntnr_pwr_unit_no_2;
                $finishedJob->ccntnr_cargo_weight = $container->cntnr_cargo_weight;
                $finishedJob->ccntnr_weight_unit = $container->cntnr_weight_unit;
                $finishedJob->ccntnr_invoice = $container->cntnr_invoice;
                $finishedJob->ccntnr_chassis_id = $container->cntnr_chassis_id;
                $finishedJob->ccntnr_chassis_type = $container->cntnr_chassis_type;
                $finishedJob->ccntnr_droponly = $container->cntnr_droponly;
                $finishedJob->ccntnr_remarks = $container->cntnr_remarks;
                $finishedJob->ccntnr_dispatcher_notes = $container->cntnr_dispatcher_notes;
                $finishedJob->ccntnr_driver_notes = $container->cntnr_driver_notes;
                $finishedJob->save();
            } else {
                MyHelper::LogStaffActionResult($driverId, 'Driver attempted to complete again for container '.$container->cntnr_name.' of job '.$booking->id, '');
            }
        }
        $complete = $_GET['complete'];
    } else {
        if (($container->cntnr_status == MyHelper::CntnrCompletedStaus()) || $containerCompleted != null) {
            MyHelper::LogStaffAction($driverId, 'Driver attempted to enter the ContainerJob4Driver page again for container '.$container->cntnr_name.' of job '.$booking->id, '');
            $complete = 'ok';
        } else {
            MyHelper::LogStaffAction($driverId, 'Driver entered the ContainerJob4Driver page for container '.$container->cntnr_name.' of job '.$booking->id, '');
        }
    }
?>

<body>
    <div class="container text-dark">
        <div>
            <div class="my-2">
                <div><img class="rounded" style="max-width:100%; height:auto" src="assets/img/pkcs.png"></div>
            </div>
        </div>
        <div>
            @if ($complete == '')
                <h2>Hi, <span style="font-family: Times New Roman; color:tomato">{{$driverName}}</span>, the following job is for you to complete. Drive safely!</h2>
            @else
                <h2>Hi, <span style="font-family: Times New Roman; color:tomato">{{$driverName}}</span>, you've just notified the dispatcher</br> that you completed the job for container: {{$cntnrName}}</br></br>Thank you!</h2>
            @endif
        </div>
        @if ($complete == '')
            <div class="card">
                <div class="card-body" style="background: #40def4;">
                    <h4 class="card-title">Container: {{$cntnrName}}</h4>
                    <div class="row mx-2">
                        <div class="col-4"><label>Chassis:&nbsp;</label></div>
                        <div class="col-8"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_chassis_id}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-4"><label>Container Length:&nbsp;</label></div>
                        <div class="col-8"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_length}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-4"><label>Cargo Weight:&nbsp;</label></div>
                        <div class="col"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_cargo_weight}}"></div>
                        @if ($container->cntnr_weight_unit == 0)
                            <div class="col"><input readonly type="text" value="Kgs"></div>
                        @else
                            <div class="col"><input readonly type="text" value="Lbs"></div>
                        @endif
                    </div>
                    <div class="row mx-2">
                        <div class="col-4"><label>Booking Number:&nbsp;</label></div>
                        <div class="col-8"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_job_no}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-4"><label>Customer Order Number:&nbsp;</label></div>
                        <div class="col-8"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_cstm_order_no}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-4"><label>Seal Number:&nbsp;</label></div>
                        <div class="col-8"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_seal_no}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-4"><label>Goods Desc:&nbsp;</label></div>
                        <div class="col-8"><input class="w-100 mb-1" readonly type="text" value="{{$container->cntnr_goods_desc}}"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="background: #94f7b5;">
                    <h4 class="card-title">Location Info:</h4>
                    <div class="row mx-2">
                        <div class="col"><label>PICKUP:&nbsp;</label></div>
                        <div class="col"><label>DROP:&nbsp;</label></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2"><label>Company:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_pickup_cmpny_name}}"></div>
                        <div class="col-2"><label>Company:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_delivery_cmpny_name}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2"><label>Address:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_pickup_cmpny_addr_1}}"></div>
                        <div class="col-2"><label>Address:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_delivery_cmpny_addr_1}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2"><label>City:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_pickup_cmpny_city}}"></div>
                        <div class="col-2"><label>City:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_delivery_cmpny_city}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2"><label>Province:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_pickup_cmpny_province}}"></div>
                        <div class="col-2"><label>Province:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_delivery_cmpny_province}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2"><label>Contact:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_pickup_cmpny_contact}}"></div>
                        <div class="col-2"><label>Contact:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_delivery_cmpny_contact}}"></div>
                    </div>
                    <div class="row mx-2">
                        <div class="col-2"><label>Tel:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_pickup_cmpny_tel}}"></div>
                        <div class="col-2"><label>Tel:&nbsp;</label></div>
                        <div class="col-4"><input readonly class="w-100 mb-1" type="text" value="{{$booking->bk_delivery_cmpny_tel}}"></div>
                    </div>
                </div>
            </div>
            <div class="card mt-1">
                <div class="card-body" style="background: #DCDCDC;">
                    <h4 class="card-title">Dispatcher Notes:</h4>
                    <div class="row mx-2">
                        <div class="col-12"><textarea readonly class="w-100 mb-1 text-danger fw-bold" type="text" rows="4">{{$container->cntnr_dispatcher_notes}}</textarea></div>
                    </div>
                    <h4 class="card-title mt-2">Driver Notes:</h4>
                    <div class="row mx-2">
                        <div class="col-12"><textarea readonly class="w-100 mb-1" type="text" rows="4">{{$container->cntnr_driver_notes}}</textarea></div>
                    </div>
                </div>
            </div>
            <div>
                <div class="row my-4">
                    <div class="col-3">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary" type="button"><a href="{{route('ContainerJob4Driver', ['driverId'=>$driverId, 'cntnrId'=>$cntnrId, 'complete'=>'ok']);}}" style="color:white; text-decoration:none">Complete This Job</a></button>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary" type="button" onclick="sendNote(this)">Send Note</button>
                    </div>
                    <div class="col-3">
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

<script>
    function sendNote(el) {         // click button once
        let jobCompleted = {!! json_encode($complete) !!};

        if (jobCompleted == '') {
            let newNote = prompt("Please enter your note", " ");
            if (newNote != null) {
                url   = './ContainerJob4Driver?cntnrId='+{!!json_encode($cntnrId)!!}+'&driverId='+{!!json_encode($driverId)!!}+'&driverNote='+newNote;
                window.location = url;
            }
        } else {
            alert('\r\nSorry!!\r\nYou cannot send a note now as this job has been completed.');
        }
    }
</script>

</html>