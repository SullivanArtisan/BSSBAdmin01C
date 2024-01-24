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
$subtotal   = 0;
$discount   = 0;
$s_tax      = '';
$subtotal   = 0;
$total      = 0;
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
                    <img class="rounded" style="max-width:100%; height:auto" src="assets/img/pkcs.png">
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
                <td style="border: 0px;width: 50%; !important"><img class="rounded" style="max-width:100%; height:auto" src="assets/img/pkcs.png"></td>
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
                <td>{{ $container->cntnr_discount * 100 }}%</td>
                <?php
                    $s_tax = ($container->cntnr_tax * 100).'%'; 
                    $temp_subtotal = $container->cntnr_total;
                    $temp_total = $container->cntnr_net;
                ?>
                <td>{{ $s_tax }}</td>
                <td>{{ $temp_subtotal }}</td>
                <td>{{ $temp_total }}</td>
            </tr>
        </table>
        <?php
            $subtotal += $temp_subtotal;
            $total +=  $temp_total;
        ?>
        @endif
    @endforeach
    <p><br/></p>
    <table>
        <tr>
            <th style="border: 1px solid #ffffff; !important">Invoice Summaries</th>
            <th style="border: 1px solid #ffffff; !important"></th>
        </tr>
        <tr style="background-color: #ffffff;" !important>
            <td style="border: 1px solid #ffffff; !important">Subtotal: ($)</td>
            <td style="border: 1px solid #ffffff; text-align: right; !important">${{ sprintf('%0.2f', $subtotal) }}</td>
        </tr>
        <tr>
            <td style="border: 1px solid #ffffff; !important">Tax:</td>
            <td style="border: 1px solid #ffffff; text-align: right; !important">${{ sprintf('%0.2f', $s_tax) }}</td>
        </tr>
        <tr style="background-color: #ffffff;" !important>
            <td style="border: 1px solid #ffffff; !important">Total: ($)</td>
            <td style="border: 1px solid #ffffff; text-align: right; !important">${{ sprintf('%0.2f', $total) }}</td>
        </tr>
    </table>
</body>
</html>