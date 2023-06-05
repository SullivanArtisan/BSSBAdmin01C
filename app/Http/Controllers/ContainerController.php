<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use App\Models\Container;
use App\Models\Booking;
use App\Models\Movement;

class ContainerController extends Controller
{
    public function add(Request $request)
    {
		$container = new Container;
		$container->cntnr_job_no        = $request->cntnr_job_no;
		$container->cntnr_name          = $request->cntnr_name;
		$container->cntnr_goods_desc    = $request->cntnr_goods_desc;
		$container->cntnr_status        = MyHelper::CntnrCreatedStaus();
		$saved = $container->save();
		
		$booking = Booking::where('bk_job_no', $request->cntnr_job_no)->first();
        // Log::info("JobType: ". $booking->bk_job_type);

        // Because the 'add' function is triggered by the Ajax function directly of the "Add this Container" button instead of the normal form's POST method through web.php's route,
        // the page's redirection in the following conditions is useless. 
        // In fact, the page's redirection is controlled in the callback function of Ajax function in the "Add this Container" button
        if(!$saved) {
            // return redirect()->route('booking_add', ['bookingResult'=>' <span style="color:red">(Failed to add the new container!)</span>', 'bookingTab'=>'containerinfo-tab', 'id'=>$booking->id]);
        } else {
            //$totalMoves = Movement::where('cntnr_job_no', $container->cntnr_job_no)->get()->count();

            $this->CreateInitialMovements($booking->id, $container->id, $container->cntnr_name, $booking->bk_job_type);
            // return view('home_page');
		}
    }

    public function update(Request $request)
    {
		$validated = $request->validate([
			//'cntnr_name'              => 'required',
		]);

        if (isset($request->id)) {
            $id = $request->id;
            Log::Info('ID = '.$request->id);
        } else {
            Log::Info('ID = null');
        }
        if (isset($request->prevPage)) {
            $prevPage = $request->prevPage;
            Log::Info('prevPage = '.$request->prevPage);
        } else {
            Log::Info('prevPage = null');
        }
        if (isset($request->selJobId)) {
            $selJobId = $request->selJobId;
            Log::Info('selJobId = '.$request->selJobId);
        } else {
            Log::Info('selJobId = null');
        }
        Log::Info('================================================================');
		
		$container = Container::where('id', $id)->first();
		// $container->cntnr_job_no              = $request->cntnr_job_no;
		// $container->cntnr_booking_no               = $request->cntnr_booking_no;
		$container->cntnr_name              = $request->cntnr_name;
		$container->cntnr_size              = $request->cntnr_size;
		if ($request->cntnr_droponly == 'on') {
			$container->cntnr_droponly = 'T';
		} else {
			$container->cntnr_droponly = 'F';
		}
		$container->cntnr_goods_desc             = $request->cntnr_goods_desc;
		$container->cntnr_ssl_release_date           = $request->cntnr_ssl_release_date;
		$container->cntnr_cstm_order_no            = $request->cntnr_cstm_order_no;
		$container->cntnr_cstm_release_date        = $request->cntnr_cstm_release_date;
		$container->cntnr_cstm_release_time         = $request->cntnr_cstm_release_time;
		$container->cntnr_trmnl_lfd            = $request->cntnr_trmnl_lfd;
		$container->cntnr_ssl_lfd   = $request->cntnr_ssl_lfd;
		$container->cntnr_mt_lfd       = $request->cntnr_mt_lfd;
		$container->cntnr_mt_release_no      = $request->cntnr_mt_release_no;
		$container->cntnr_empty_return_trmnl     = $request->cntnr_empty_return_trmnl;
		$container->cntnr_ssl    = $request->cntnr_ssl;
		$container->cntnr_seal_no    = $request->cntnr_seal_no;
		$container->cntnr_cargo_weight    = $request->cntnr_cargo_weight;
		if ($request->cntnr_weight_unit == 'Kgs') {
			$container->cntnr_weight_unit = 0;
		} else {
			$container->cntnr_weight_unit = 1;
		}
		$container->cntnr_chassis_type    = $request->cntnr_chassis_type;
		$container->cntnr_chassis_id    = $request->cntnr_chassis_id;

		$saved = $container->save();
		
		if(!$saved) {
			return redirect()->route('op_result.container')->with('status', ' <span style="color:red">Data has NOT been updated!</span>');
		} else {
            if (!isset($request->prevPage)) {
                return redirect()->route('op_result.container', ['id'=>$request->id])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been updated successfully.');
            } else {
                return redirect()->route('op_result.container', ['id'=>$request->id, 'prevPage'=>$prevPage, 'selJobId'=>$selJobId])->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been updated successfully.');
            }
        }
    }

    private function CreateInitialMovements(String $jobId, String $cntnrId, String $cntnrName, String $jobType) {
        $jobType = str_replace("\xc2\xa0", ' ', $jobType);
        Log::info("JobType: ".$jobType." | ".MyHelper::$allJobTypes[2]);
        if ($jobType == MyHelper::$allJobTypes[0]) {   // Import ==> 4 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[4];       // Port Pickup
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[7];       // Customer Drop
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_3";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[6];       // Customer Pickup
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_4";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[15];       // Empty Drop
            $saved = $movement->save();
        } else if ($jobType == MyHelper::$allJobTypes[1]) {   // Export ==> 4 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[14];       // Empty Pickup
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[7];       // Customer Drop
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_3";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[6];       // Customer Pickup
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_4";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[5];       // Port Drop
            $saved = $movement->save();
        } else if ($jobType == MyHelper::$allJobTypes[2]) {   // Empty Repo ==> 2 movements
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[0];       // Container Pickup
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = MyHelper::$allMovementTypes[1];       // Container Drop
            $saved = $movement->save();
        } else {   // Yard Move or Other or CBSA    ==> 2 movements 
            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_1";
            $movement->mvmt_type        = "";                                   // ?
            $saved = $movement->save();

            $movement = new Movement;
            $movement->mvmt_bk_id    = $jobId;
            $movement->mvmt_cntnr_name  = $cntnrName;
            $movement->mvmt_name        = "J_".$jobId."_C_".$cntnrId."_M_2";
            $movement->mvmt_type        = "";                                   // ?
            $saved = $movement->save();
        }
    }

}
