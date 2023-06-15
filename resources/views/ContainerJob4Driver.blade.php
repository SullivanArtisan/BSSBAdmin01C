<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>ContainerJob4Driver</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
</head>

<?php
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
        $cntnrName = $container->cntnr_name;
    }

    if (isset($_GET['complete'])) {
        $finishedJob = new container_completed;
        $finishedJob->ccntnr_id = $cntnrId;
        $finishedJob->ccntnr_job_id = $booking->id;
        $finishedJob->ccntnr_dvr_id = $driverId;
        $finishedJob->ccntnr_finished_on = date("Y-m-d H:i:s");
        $finishedJob->ccntnr_received = 'N';
        $finishedJob->save();

        $complete = $_GET['complete'];
    }
?>

<body>
    <div class="container">
        <div>
            <div class="my-4">
                <div><img class="rounded" style="max-width:100%; height:auto" src="assets/img/HarbourLink.jpg"></div>
            </div>
        </div>
        <div>
            @if ($complete == '')
                <h2>Hi, {{$driverName}}, the following job is for you to complete. Drive safely!</h2>
            @else
                <h2>Hi, {{$driverName}}, you've just notified the dispatcher</br> that you completed the job for container: {{$cntnrName}}</br></br>Thank you!</h2>
            @endif
        </div>
        @if ($complete == '')
            <div class="card">
                <div class="card-body" style="background: #40def4;">
                    <h4 class="card-title">Container: {{$cntnrName}}</h4>
                    <h6 class="text-muted card-subtitle mb-2">Subtitle</h6>
                    <p class="card-text">Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p><a class="card-link" href="#">Link</a><a class="card-link" href="#">Link</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body" style="background: #94f7b5;">
                    <h4 class="card-title">Movements:</h4>
                    <h6 class="text-muted card-subtitle mb-2">Subtitle</h6>
                    <p class="card-text">Nullam id dolor id nibh ultricies vehicula ut id elit. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus.</p><a class="card-link" href="#">Link</a><a class="card-link" href="#">Link</a>
                </div>
            </div>
            <div>
                <div class="row my-4">
                    <div class="col-3">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary" type="button"><a href="{{route('ContainerJob4Driver', ['driverId'=>$driverId, 'cntnrId'=>$cntnrId, 'complete'=>'ok']);}}" style="color:white">Complete This Job</a></button>
                    </div>
                    <div class="col-2">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary" type="button">Send Note</button>
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
    window.onload = function() {
        // jobDone = {!!json_encode($complete)!!}

        // if (jobDone.length == 0) {
        //     alert('To complete this job!');
        // } else {
        //     alert(jobDone);
        // }
    }
</script>

</html>