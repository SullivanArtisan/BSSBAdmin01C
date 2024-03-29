<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>PKCS Control/Management System</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
    <style>
        .menulistitem {
            color: Khaki;
        }
    </style>

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    use Illuminate\Support\Facades\Log;
    use App\Helper\MyHelper;
    use Illuminate\Support\Facades\Session;

    $config_lifetime = config('session.lifetime') * 60;
    $login_time = Session::get('login_time');
    ?>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3 style="font-family: Georgia; color:Gold">Port Kells Container Services</h3>
                <h6 style="font-family: Georgia; color:LightCyan"><?php echo date("m/d/Y l");?></h6>
            </div>

            <ul class="list-unstyled components">
				<div class="ml-2 mb-3">
					<a href="{{route('home_page')}}"><span style='font-size:30px;'>&#127968;</span><span style='font-weight:bold; color:Gold'>&nbsp&nbspHome</span></a>
				</div>
                <!--
                <li class="active">
                    <a href="#controlSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Control</a>
                    <ul class="collapse list-unstyled" id="controlSubmenu">
                        <li> <a href="#">Active Jobs</a> </li>
                        <li> <a href="#">Enter New Job</a> </li>
                        <li> <a href="#">Display Map</a> </li>
                        <li> <a href="#">Display Chassis Locations</a> </li>
                        <li> <a href="#">View Last Job</a> </li>
                        <li> <a href="#">View By Job Number</a> </li>
                    </ul>
                </li>
                -->
                <li>
                    <a href="#tcefSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-weight:bold;color:Purple">Main Functions...</a>
                    <ul class="collapse list-unstyled" id="tcefSubmenu">
                        <li class="menulistitem"> <a href="{{route('booking_add')}}">Enter New Job</a> </li>
                        <li class="menulistitem"> <a href="{{route('booking_main')}}">All Bookings</a> </li>
                        <li class="menulistitem"> <a href="{{route('container_main')}}">All Containers</a> </li>
                        <li class="menulistitem"> <a href="{{route('invoice_main')}}">All Invoices</a> </li>
                        <li class="menulistitem"> <a href="{{route('dispatch_main')}}">Dispatch</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle" style="font-weight:bold;color:Purple">All Data...</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li class="menulistitem"> <a href="{{route('customer_main')}}">Customer File</a> </li>
                        <li class="menulistitem"> <a href="#driverFileSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Driver File</a> </li>
							<ul class="collapse list-unstyled mx-4" id="driverFileSubmenu">
							  <li class="menulistitem"><a href="{{route('driver_main')}}">All Drivers</a></li>
							  <li class="menulistitem"><a href="{{route('driver_pay_prices_main')}}">Driver Pay Rates</a></li>
							</ul>						
                        <li class="menulistitem"> <a href="{{route('ssl_main')}}">Steamship Line DB</a> </li>
                        <li class="menulistitem"> <a href="#addressSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Address DB</a> </li>
							<ul class="menulistitem collapse list-unstyled mx-4" id="addressSubmenu">
							  <li class="menulistitem"><a href="{{route('terminal_main')}}">Terminals</a></li>
							  <li class="menulistitem"><a href="{{route('company_main')}}">Company Addresses</a></li>
							</ul>						
                        <li class="menulistitem"> <a href="{{route('system_user_main')}}">System Users</a> </li>
                        <li class="menulistitem"> <a href="{{route('zone_main')}}">Zones</a> </li>
                        <li class="menulistitem"> <a href="{{route('power_unit_main')}}">Power Units</a> </li>
                        <li class="menulistitem"> <a href="{{route('chassis_main')}}">Chassis List</a> </li>
                    </ul>
                </li>
                <!--
                <li>
                    <a href="#tcefSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">TCEF</a>
                    <ul class="collapse list-unstyled" id="tcefSubmenu">
                        <li> <a href="#">Enter CBSA Job</a> </li>
                        <li> <a href="#">View CBSA Jobs</a> </li>
                    </ul>
                </li>
                <li>
                    <a href="#salesLedgerSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Sales Ledger</a>
                    <ul class="collapse list-unstyled" id="salesLedgerSubmenu">
                        <li> <a href="#">View Sales Ledger</a> </li>
                        <li> <a href="#">Import Payments File</a> </li>
                    </ul>
                </li>
                -->
            </ul>

			<!--
            <ul class="list-unstyled CTAs">
                <li>
                    <a href="https://bootstrapious.com/tutorial/files/sidebar.zip" class="download">Download source</a>
                </li>
                <li>
                    <a href="https://bootstrapious.com/p/bootstrap-sidebar" class="article">Back to article</a>
                </li>
            </ul>
			-->
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

					<!--
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
					-->

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
						<div class="col-md-6">
							<div><img class="rounded" style="max-width:100%; height:auto" src="assets/img/pkcs.png"></div>
						</div>
                        <ul class="nav navbar-nav ml-auto">
							@yield('goback')
							<form method="POST" action="{{ route('logout') }}" id="form_logout" style="cursor: pointer">
								@csrf

								<a style="margin-right: 50px; text-decoration:underline;"  class="text-warning"
									onclick="event.preventDefault(); this.closest('form').submit();">
									<i></i>
									{{ __('Log Out') }}
								</a>
							</form>
							<!--
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Page</a>
                            </li>
							-->
                        </ul>
                    </div>
                </div>
            </nav>

			<div class="w-100 p-1"  style="background-color: #e8f5e9">
				@yield('function_page')
			</div>
			
			<!--
            <div class="line"></div>

            <h2>Lorem Ipsum Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h2>Lorem Ipsum Dolor</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <div class="line"></div>

            <h3>Lorem Ipsum Dolor</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			-->
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

        <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar, #content').toggleClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });

        var globalTimeout = setTimeout(ReloadAllJobMsgs, 1500);     // mili-seconds
        function ReloadAllJobMsgs() {
            var configLifetime = {!!json_encode($config_lifetime)!!};
            var loginTime      = {!!json_encode($login_time)!!};
            var secondsNow     = Date.now()/1000;

            if (secondsNow > loginTime + configLifetime - 300) {     // in seconds
                clearTimeout(globalTimeout);
                $.ajax({
                    url: 'process_lifetime_expires',
                    type: 'POST',
                    data: {
                        _token:"{{ csrf_token() }}", 
                        from_role: '',
                    },    // the _token:token is for Laravel
                    success: function(dataRetFromPHP) {
                        document.getElementById('form_logout').submit();
                    },
                    error: function(err) {
                    }
                });
            } else {
                globalTimeout = setTimeout(ReloadAllJobMsgs, 7500); // mili-seconds
            }

        }
    </script>
</body>

</html>