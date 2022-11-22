<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>BSSBAdmin01C</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Hero-Clean-images.css">
</head>

<body>
    <div class="container py-4 py-xl-5" style="background: linear-gradient(#70c950, white), var(--bs-teal);">
        <div class="row gy-4 gy-md-0" style="height: 250px;">
            <div class="col-md-6" style="height: 250px;">
                <div style="height: 250px;"><img class="rounded img-fluid w-100 fit-cover" style="max-height: 100%;max-width: 100%;" src="assets/img/HarbourLink.jpg"></div>
            </div>
            <div class="col-md-6 d-md-flex align-items-md-center" style="height: 250px;">
                <div style="max-width: 350px;margin-left: 65px;height: 250px;">
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40.172px;margin-bottom: 0px;">Harbourlink</h2>
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40px;margin-bottom: 0;">COntrol &amp;</h2>
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40px;margin-bottom: 0;">management</h2>
                    <h2 class="text-uppercase fw-bold" style="width: 355px;height: 40px;margin-bottom: 0;">system</h2>
					<div class="row" style="margin-top:50px; margin-left:100px">
						<a href="{{route('home_page_old')}}" style="margin-right: 10px;">Back</a>
						<a href="#" style="margin-right: 10px;">Enter new system user</a>
						<form method="POST" action="{{ route('logout') }}" style="cursor: pointer">
							@csrf
							<a style="margin-right: 10px; text-decoration:underline;"  class="text-warning"
								onclick="event.preventDefault(); this.closest('form').submit();">
								<i></i>
								{{ __('Log Out') }}
							</a>
						</form>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <header style="height: 22px;background: var(--bs-blue);"></header>
        <div class="row">
            <div class="col">
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>