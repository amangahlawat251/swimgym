<?php 
$pagecode = "PO-009";
include 'includes/check_session.php';
$pageno = 1; 
?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!--**********************************  Header End  ***********************************-->
	<!--**********************************  Header Start  ***********************************-->
	<?php require_once("includes/header.php"); ?>
	
	<!--**********************************  Header End  ***********************************-->
	<title>Dashboard | <?php echo APPLICATION_NAME; ?> </title>
	<!--**********************************  Sidebar Start  ***********************************-->
	<?php require_once("includes/sidebar.php"); ?>
	<!--**********************************  Sidebar End  ***********************************-->
	<!--**********************************  Content body start  ***********************************-->
	
	<div class="content-body">
		<!-- row -->
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="javascript:void(0)">
						<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round" />
							<path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
					</a>
				</li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
			</ol>
		</div>


		<div class="container-fluid">
			<div class="row">
				<div class="<?php if ($_SESSION['user_type'] == 'SUPERADMIN') { echo 'col-xl-3';}else{ echo'col-xl-4'; }?>  col-lg-6 col-sm-6">
						<div class="card bg-info">
							<div class="card-body">	
								<div class="students d-flex align-items-center justify-content-between flex-wrap">
									<div>
									<?php 

				 $sql = "select  count(id) as count_rows from ".MEMBERS." where 1";
				// echo $sql;
				$result = $mysqli->executeQry($sql) ; 
				$num_arr= $mysqli->fetch_array($result);
				$num = $num_arr['count_rows'];		
				?>
										<h4><?php echo $num;?></h4>
										<h5>Total Members</h5>
									</div>
									<div>
									<i aria-hidden="true" class="fa fa-users" style="color: #fff;font-size: 40px;"></i>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="<?php if ($_SESSION['user_type'] == 'SUPERADMIN') { echo 'col-xl-3';}else{ echo'col-xl-4';} ?>  col-lg-6 col-sm-6">
						<div class="card bg-success  overflow-hidden">
							<div class="card-body">	
								<div class="students d-flex align-items-center justify-content-between flex-wrap">
									<div>
									<?php 

				 $sql = "select  count(id) as count_rows from ".MEMBERS." where status = 'Active'";
				// echo $sql;
				$result = $mysqli->executeQry($sql) ; 
				$num_arr= $mysqli->fetch_array($result);
				$num_active = $num_arr['count_rows'];		
				?>
										<h4><?php echo $num_active;?></h4>
										<h5>Total Active Members</h5>
									</div>
									<div>
									<i aria-hidden="true" class="fa fa-user-plus" style="color: #fff;font-size: 40px;"></i>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<div class="<?php if ($_SESSION['user_type'] == 'SUPERADMIN') { echo 'col-xl-3';}else{ echo'col-xl-4';} ?>  col-lg-6 col-sm-6">
						<div class="card bg-warning  overflow-hidden">
							<div class="card-body">	
								<div class="students d-flex align-items-center justify-content-between flex-wrap">
									<div>
									<?php 

				 $sql = "select  count(id) as count_rows from ".MEMBERS." where status = 'Expired'";
				// echo $sql;
				$result = $mysqli->executeQry($sql) ; 
				$num_arr= $mysqli->fetch_array($result);
				$num_active = $num_arr['count_rows'];		
				?>
										<h4><?php echo $num_active;?></h4>
										<h5>Total Inactive Members</h5>
									</div>
									<div>
									<i aria-hidden="true" class="fa fa-user-times" style="color: #fff;font-size: 40px;"></i>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<?php if ($_SESSION['user_type'] == 'SUPERADMIN') { ?>
					<div class="<?php if ($_SESSION['user_type'] == 'SUPERADMIN') { echo 'col-xl-3';}else{ echo'col-xl-4';} ?>  col-lg-6 col-sm-6">
						<div class="card bg-danger  overflow-hidden">
							<div class="card-body">	
								<div class="students d-flex align-items-center justify-content-between flex-wrap">
									<div><?php
									$sql = "SELECT SUM(amount_received) AS total_amount_paid
												FROM tbl_revenue";
										// echo $sql;
										$result = $mysqli->executeQry($sql);
										$sum_arr = $mysqli->fetch_array($result);
										$total_amount_paid = $sum_arr['total_amount_paid'];
										?>
										<h4>₹ <?php echo $total_amount_paid;?></h4>
										<h5>Total Revenue</h5>
									</div>
									<div>
									<i aria-hidden="true" class="fa fa-inr" style="color: #fff;font-size: 40px;"></i>
									</div>
								</div>
							</div>
						</div>
                    </div>
					<?php }?>
				</div>
				<div class="col-xl-12">


				<div class="filter cm-content-box box-primary">
					<div class="content-title">
						<div class="cpa">
							<i class="fa-sharp fa-solid fa-filter me-2"></i>Filter
						</div>
						<div class="tools">
							<a href="javascript:void(0);" class="SlideToolHeader"><i class="fal fa-angle-down"></i></a>
						</div>
					</div>
					<div style="display:none;" class="cm-content-body form excerpt">
						<div class="card-body">
							<form onsubmit="return false;" id="frm_search" method="post">
								
								<div class="row">



									<div class="col-md-2">
										<label class="form-label">Search by membership ID</label>
										<input type="text" class="form-control  " maxlength="150" id="membership_id" name="membership_id" placeholder="" />
									</div>
									<div class="col-md-2">
										<label class="form-label">Search by date</label>
										<input type="date" name="att_date" id="att_date" class="form-control" required  value="<?php echo date('Y-m-d');?>" required />
									</div>

									<div class="col-md-2">
											<button style="margin-top: 30px;" id="search" type="submit" class="btn btn-sm btn-primary">Search</button>
											<button style="margin-top: 30px; margin-left:5px;" type="reset" onclick="window.location.reload();" class="btn btn-sm  btn-primary">Reset</button>
										
									</div>

								</div>
								<input type='hidden' name='tab' value="<?php echo 'view_recent_visitors'; ?>" />					
					<input type="hidden" name="url" id="url" value="<?php echo "index.php?".$mysqli->encode("stat=table_response"); ?>" required>			  
					<input type="hidden" name="record_limit" id="record_limit" value="10"> 			
					<input type='hidden' name='download' id='download' value="" />		 
					<input type="hidden" name="page" id="page" value="<?php echo $pageno; ?>">  
							</form>
						</div>
					</div>

				</div>
			</div>
				
				<div class="col-xl-12">
				<div class="card dz-card">
					<div class="card-header flex-wrap">
						<h4 class="heading mb-0">Recent Visitors</h4>
					<ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
							<li class="nav-item" role="presentation">
								<a href="javascript:void(0);" onclick="export_attendance()" class="btn btn-success text-white btn-sm" style="margin-right:10px;"><i class="fa fa-download"></i></a>
							</li>
						</ul>
						<div class="card-tools" style="display:none;">
					Reloading in (Seconds): <span style="color:#fff;font-weight:bold" id='timee'></span> &nbsp;&nbsp;
					<a href="javascript:void(0)">
						<i class="fa fa-pause icon-lg" aria-hidden="true" id="timercontroller" onclick="stoptimer()" title="Pause"></i>
					</a>                  
                  
                </div>
					</div>
					<div id="dynamic_div" class="table-responsive">
					<div class="card-body">
						
					</div>					
					
				</div>	
				</div>
			</div>
				
			</div>


		</div>

		<script type="text/javascript" src="https://www.google.com/jsapi"></script>

	</div>
	<!--**********************************  Content body end  ***********************************-->

	<!--**********************************  Footer Start  ***********************************-->
	<?php include_once("includes/footer.php");
include_once("includes/dynamic_table.php") ;	?>
	<!--**********************************  Footer End  ***********************************-->
	 <script src="./js/cms.js"></script>
	<script>
	function export_attendance() {
        //console.log('hi');
        $('#preloader').show();
        var membership_id = $('#membership_id').val();
        var att_date = $('#att_date').val();
        var data = {};
        data.tab = 'export_attendance';
        data.membership_id = membership_id;
        data.att_date = att_date;
        $.ajax({
            type: "POST",
            url:"index.php?<?php echo $mysqli->encode('stat=export_ajax');?>",
            data: data,
            dataType: "json",
			timeout: 0,
            beforeSend: function () {
				$("#preloader").show();
			},
            success: function(data) {
				//console.log(data);return false;
				if (data.msg_code != '00') {
					toastr.error(data.msg);
				}else{
					 var link = document.createElement('a');
                link.href = data.redirect;
                link.download = data.redirect.split('/').pop();
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
				}
                $('#preloader').hide();
            },
			error: function ( jqXHR, exception ){
                $('#preloader').hide();
			} 
        });
		// }
    }
	</script>
	</body>

</html>