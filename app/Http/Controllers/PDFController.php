<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Booking;
use PDF;

class PDFController extends Controller
{
    public function generatePDF () {
        $data = [
            'title' => 'Welcome to Port Kells Container Services',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('myPDF', $data);

        return $pdf->download('welcome_to_hl.pdf');
    }

    public static function sendInvoice ($booking, $invoice_file_name) {
        $pdf = PDF::loadView('invoice_create', compact('booking'));

        $result = file_put_contents($invoice_file_name, $pdf->Output());
        if (!$result) {
            Log::Info("file_put_contents failed.");
            return FALSE;
        } else {
            Log::Info("file_put_contents OK!");
            return TRUE;
        }
    }
}
