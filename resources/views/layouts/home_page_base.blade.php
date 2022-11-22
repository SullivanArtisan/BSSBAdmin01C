<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>HarbourLink Control/Management System</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style2.css">
    <!-- Scrollbar Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>HarbourLink</h3>
            </div>

            <ul class="list-unstyled components">
				<div class="m-3">
					<a href="{{route('home_page')}}">Home</a>
				</div>
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
                <li>
                    <a href="#adminSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Administration</a>
                    <ul class="collapse list-unstyled" id="adminSubmenu">
                        <li> <a href="#">Customer File</a> </li>
                        <li> <a href="#">Driver File</a> </li>
                        <li> <a href="#">Invoicing</a> </li>
                        <li> <a href="#">Driver Pay</a> </li>
                        <li> <a href="#">Steamship Line DB</a> </li>
                        <li> <a href="#">Address DB</a> </li>
                        <li> <a href="{{route('system_user_main')}}">System Users</a> </li>
                        <li> <a href="#">Zones</a> </li>
                        <li> <a href="#">Power Units</a> </li>
                        <li> <a href="#">Accessorial Charges</a> </li>
                        <li> <a href="#">Chissis List</a> </li>
                        <li> <a href="#">Reports</a> </li>
                        <li> <a href="#">Security Levels</a> </li>
                        <li> <a href="#">System Settings</a> </li>
                    </ul>
                </li>
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
							<div><img class="rounded" style="max-width:100%; height:auto" src="assets/img/HarbourLink.jpg"></div>
						</div>
                        <ul class="nav navbar-nav ml-auto">
							@yield('goback')
							<form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
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
    </script>
</body>

</html>