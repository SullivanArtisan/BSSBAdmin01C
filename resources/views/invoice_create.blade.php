<?php
use App\Models\Booking;
use App\Models\Container;
use App\Models\Customer;
use App\Models\Invoice;

$job_no     = $booking->bk_job_no;
$customer   = Customer::where('cstm_account_no', $booking->bk_cstm_account_no)->first();
$invoice    = Invoice::where('inv_job_no', $booking->bk_job_no)->first();
$containers = Container::where('cntnr_job_no', $booking->bk_job_no)->get();
$idx        = 1;
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #cdcdcd;
        }

        .subtitlestyle {
            font-family: arial, sans-serif;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <p>Invoice for Job: {{ $job_no }}</p>

    <?php
    ?>
    <div>
        <table>
            <!-- <div>
                <div>
                    <p>From: {{ $job_no }}</p>
                </div>
                <div class="row">
                    <img class="rounded" style="max-width:100%; height:auto" src="assets/img/HarbourLink.jpg">
                </div>
            </div>
            <div>
                <div>
                    <p>To: {{ $job_no }}</p>
                </div>
            </div> -->
            <tr style="background-color: #ffffff; !important">
                <th style="border: 0px;width: 50%; !important">From: </th>
                <th style="border: 0px;width: 50%; !important">To: </th>
            </tr>
            <tr style="background-color: #ffffff; !important">
                <td style="border: 0px;width: 50%; !important"><img class="rounded" style="max-width:100%; height:auto" src="assets/img/HarbourLink.jpg"></td>
                <td style="border: 0px;width: 50%; !important">{{ $customer->cstm_account_name }}<br/>{{ $customer->cstm_address }}<br/>{{ $customer->cstm_city }}, {{ $customer->cstm_province}}<br/>{{$customer->cstm_postcode}}<br/>{{$customer->cstm_contact_email1}}</td>
            </tr>
        </div>
    </div>
    <p class="subtitlestyle">Invoice No.: {{ $invoice->inv_serial_no }}</p>
    <p class="subtitlestyle">Invoice Issued Date: {{ $invoice->inv_issued_date }}</p>
    <p class="subtitlestyle">Invoice Due Date: {{ $invoice->inv_due_date }}</p>
    <p><br/></p>
    @foreach ($containers->all() as $container)
        @if ($container->cntnr_status != 'deleted') 
        <p>Item {{ $idx++ }}: Container {{ $container->cntnr_name }}</p>
        <table>
            <tr>
                <th>Cost</th>
                <th>Surcharges</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Total Price</th>
                <th>Net Price</th>
            </tr>
            <tr>
                <td>{{ $container->cntnr_cost }}</td>
                <td>{{ $container->cntnr_surcharges }}</td>
                <td>{{ $container->cntnr_discount }}</td>
                <td>{{ $container->cntnr_tax }}</td>
                <td>{{ $container->cntnr_total }}</td>
                <td>{{ $container->cntnr_net }}</td>
            </tr>
        </table>
        @endif
    @endforeach
    <p><br/></p>
    <p class="subtitlestyle">Invoice Summaries</p>
    <p class="subtitlestyle">Subtotal: xxxx</p>
    <p class="subtitlestyle">Tax: xxxx</p>
    <p class="subtitlestyle">Total: xxxx</p>
</body>
</html>