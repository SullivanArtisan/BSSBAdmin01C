<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Helper\MyHelper;
use Illuminate\Http\Request;
use App\Models\Container;

class ContainerController extends Controller
{
    public function add(Request $request)
    {
		$container = new Container;
		$container->cntnr_job_no        = "ML001526";
		$container->cntnr_name          = $request->cntnr_name;
		$container->cntnr_goods_desc    = $request->cntnr_goods_desc;
		$container->cntnr_status        = MyHelper::CntnrCreatedStaus();
		$saved = $container->save();
		
		if(!$saved) {
            //Log::info("HOHOHO: ". $request->cntnr_goods_desc);
            return redirect()->route('op_result.customer')->with('status', 'The customer,  <span style="font-weight:bold;font-style:italic;color:blue">'."HOHOHO".'</span>, has been updated successfully.');
		} else {
            //Log::info("HAHAHA: ". $request->cntnr_name);
			return view('home_page');
		}
    }

    public function update(Request $request)
    {
		$validated = $request->validate([
			//'cntnr_name'              => 'required',
		]);
		
		$container = Container::where('id', $request->id)->first();
		// $container->cntnr_job_no              = $request->cntnr_job_no;
		$container->cntnr_booking_no               = $request->cntnr_booking_no;
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
			return redirect()->route('op_result.container')->with('status', 'The container,  <span style="font-weight:bold;font-style:italic;color:blue">'.$container->cntnr_name.'</span>, has been updated successfully.');
		}
    }
}
