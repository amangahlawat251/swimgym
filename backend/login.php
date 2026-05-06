<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="<?php echo APPLICATION_NAME; ?>">
	<meta property="og:description" content="Swim Gym Academy">
	<meta property="og:image" content="<?php echo FAVICON_PATH; ?>">
	<title>Login | <?php echo APPLICATION_NAME; ?> </title>
	<link rel="shortcut icon" type="image/png" href="<?php echo FAVICON_PATH; ?>">
	<link href="<?php echo  APPLICATION_URL; ?>/backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="<?php echo  APPLICATION_URL; ?>/backend/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/toastr/toastr.min.css">
	<style>
		.btn-primary {
			border-color: #2b388f;
			background-color: #2b388f;
		}
	</style>
	<!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->
</head>

<body class="vh-100">

	<div id="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
	</div>

	<div class="page-wraper">

		<!-- Content -->
		<div class="browse-job login-style3">
			<!-- Coming Soon -->
			<div class="bg-img-fix overflow-hidden" style="background:#fff url(<?php echo  APPLICATION_URL; ?>/backend/images/background/bg6.gif);background-repeat: no-repeat; background-size: 60%;  background-position-x: left;background-position-y: center;">
				<div class="row gx-0" style="display: inherit !important;">
					<div style="padding-top: 110px;float:right" class="col-xl-4 col-lg-5 col-md-6 col-sm-12 vh-100 bg-white ">

						

						<div id="mCSB_2" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" style="max-height: 653px;" tabindex="0">
							<div id="mCSB_1_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
								<div class="login-form style-2">

									<div class="card-body">


										<nav>
											<div class="nav nav-tabs border-bottom-0" id="nav-tab" role="tablist">

												<div class="tab-content w-100" id="nav-tabContent">
													<div class="tab-pane fade show active" id="nav-personal" role="tabpanel" aria-labelledby="nav-personal-tab">

														<form action="" onsubmit="return false;" autocomplete="off" id="frm" method="post">
															<center>
															<img style="margin-top: 75px;text-align: center;margin: auto; width:110px;" src="<?php echo LOGO_PATH; ?>" alt="" class="width-230 light-logo">
																<h3 class="form-title m-t0">Login</h3>
															</center></br>
															<div class="dz-separator-outer m-b5">
																<div class="dz-separator bg-primary style-liner"></div>
															</div>

															<div class="form-group mb-3 login_type staff_login">
																<input type="email" name="user_email" class="form-control removeChars" data-regex="[^a-zA-Z0-9-.,_@/]" placeholder="Enter your email" autofocus required>
															</div>

															<div class="form-group mb-3 login_type staff_login">
																<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
															</div>
														
															<input type="hidden"   name="url" id="url" value="<?php echo "index.php?".$mysqli->encode("stat=ajax&tab=login"); ?>" required>
															<div class="form-group text-left forget-main">
																<center><button type="submit" class="btn btn-primary">Sign Me In</button></center>

																<center><a style="margin-top:10px;" class="btn-link forget-tab " id="nav-forget-tab" data-bs-toggle="tab" data-bs-target="#nav-forget" type="button" role="tab" aria-controls="nav-forget" aria-selected="false">Forget Password ?</a> </center>
															</div>
															
														</form>
														
													</div>
													
												</div>

											</div>
										</nav>
									</div>
									<div class="card-footer">
										<div class=" bottom-footer clearfix m-t10 m-b20 row text-center">
											<div class="col-lg-12 text-center">
												<span> © Copyright <?php echo date('Y') ?> <span class="heart"></span>
													<a href="javascript:void(0);"><u><?php echo COMPANY_NAME; ?></u></a> All rights reserved.</span>
											</div>
										</div>
									</div>

								</div>
							</div>
							<div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;">
								<div class="mCSB_draggerContainer">
									<div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 0px; display: block; height: 652px; max-height: 643px; top: 0px;">
										<div class="mCSB_dragger_bar" style="line-height: 0px;"></div>
										<div class="mCSB_draggerRail"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Full Blog Page Contant -->
		</div>
		<!-- Content END-->
	</div>

	<!--**********************************
	Scripts
***********************************-->
	<!-- Required vendors -->
	<script src="<?php echo  APPLICATION_URL; ?>/backend/vendor/global/global.min.js"></script>
	<script src="<?php echo  APPLICATION_URL; ?>/backend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="<?php echo  APPLICATION_URL; ?>/backend/js/deznav-init.js"></script>
	<script src="<?php echo  APPLICATION_URL; ?>/backend/js/custom-script.js"></script>
	<script src="vendor/toastr/toastr.min.js"></script>
	<script type="text/javascript">
  $(document).ready(function() {
    $("#preloader").hide();
  });
</script>
</body>

</html>