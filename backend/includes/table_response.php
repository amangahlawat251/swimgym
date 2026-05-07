<?php
include 'check_session.php';
 
if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') 
{
	echo "<script language='javascript' type='text/javascript'>";
    echo "alert('Request not identified as ajax request');";
    echo "</script>";
	$URL="index.php";
	echo "<script>location.href='$URL'</script>";
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo "<script language='javascript' type='text/javascript'>";
    echo "alert('Bad Request method');";
    echo "</script>";
	$URL="index.php";
	echo "<script>location.href='$URL'</script>";
}
#print_r($_POST);
extract($_REQUEST);
$table = "";
if ($tab == 'view_members')
{
	$con = "";
	if (!isset($sort_param))
    $sort_param = "id";

	if (!isset($page) || $page < 1) {
		$page = 1;
	}

	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}

	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}

	if (isset($page)) {
		$start    = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page  = 1;
		$start = 1;
	}
		
	if (!empty($membership_id) || $membership_id != "") {
		$con .= " and member_id = '" . trim($membership_id) . "'";
	}
	if (!empty($search_user_name) || $search_user_name != "") {
		$con .= " and name like '%" . trim($search_user_name) . "%'";
	}

	if (!empty($search_user_email) || $search_user_email != "") {
		$con .= " and email = '" . trim($search_user_email) . "'";
	}

	if (!empty($search_user_contact) || $search_user_contact != "") {
		$con .= " and mobile = '" . trim($search_user_contact) . "'";
	}
	if (!empty($search_status) || $search_status != "") {
		$con .= " and status = '" . trim($search_status) . "'";
	}
	if (!empty($plan_type) || $plan_type != "") {
		$con .= " and plan_id IN (" . $plan_type . ")";
	}
	if (!empty($freezed) || $freezed != "") {
		$con .= " and is_freezed = '" . trim($freezed) . "'";
	}
	
	 $sql = "select * from ".MEMBERS." where 1 ".$con." order by id DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".MEMBERS." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	$row = "";	 
	
	if($num > 0)
	{						
		$count             = $num;
		$no_of_paginations = ceil($count / $per_page);
		$cur_page          = $cur_page;
		$previous_btn      = true;
		$next_btn          = true;
		$first_btn         = true;
		$last_btn          = true;
	      
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3">
				<div class="form-group pull-left">
					<label for="input" class="control-label">Record Limit:<span></span></label>					
						<select name="record_limit_change" id="record_limit_change" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="120">120</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>			
					
				</div>
			</div>
			<div class="col-md-6"></div>

			<div class="col-md-3">
				<div class="form-group pull-right">
					<label for="input" class="control-label">Search:<span></span></label>					
					<input type="text" id="live_search" class="form-control" />				
				</div>
			</div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<div style="margin: 2px; float: left;"></div>
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead>
		<tr>
		<th><nobr>#</nobr></th>';
		
			$table .= '<th><nobr>Action</nobr></th>';
		
		$table .= '<th><nobr>Status</nobr></th><th><nobr>Payment</nobr></th><th><nobr>Membership ID</nobr></th><th><nobr>Name</nobr></th>';		
		//$table .= '<th><nobr>Email</nobr></th>';		
		$table .= '<th><nobr>Mobile</nobr></th>
		<th><nobr>Gender</nobr></th>
		<th><nobr>Plan</nobr></th>
		<th><nobr>Timing</nobr></th>
		<th><nobr>Start Date</nobr></th>
		<th><nobr>End Date</nobr></th>
		
		<th><nobr>Payment Mode</nobr></th>';
		if($_SESSION['user_type'] == 'SUPERADMIN'){
		$table .= '<th><nobr>Amount Paid</nobr></th>';
		}
		$table .= '<th><nobr>Created On</nobr></th>
		</tr>
		</thead>	
		<tbody id="tbody">';
			if($num>0)
			{
				$n = 1;
				$data = "";
				while($rows = $mysqli->fetch_assoc($result))
				{	 									
					$country_code = '';
					$i = ($start + $n);
				
				
					foreach($rows as $key => $value)
					{
						$data .= "data-".$key."='".$value."' ";											
					}
								
					extract($rows);
					$plan_details = $mysqli->singleRowAssoc_new('*', PLANS, 'id = "'.$plan_id.'"');
					$btn = "&nbsp;<span style='cursor:pointer;' class='btn btn-primary shadow btn-xs sharp me-1 user-edit-form' data-hover='tooltip' ".$data."  data-id='".$mysqli->encode($id)."'  data-placement='top' title='Click here edit' id='".$id."' ><i class='fa  fa-pencil'></i></span>";
					$dec_btn = "&nbsp;<span style='cursor:pointer;' class='btn btn-info shadow btn-xs sharp me-1' data-hover='tooltip' ".$data." onclick='declaration(this.id);' data-id='".$mysqli->encode($id)."'  data-placement='top' title='Click here to print declaration form' id='".$id."' ><i class='fa fa-file-text'></i></span>";
		
					$inv_btn = "&nbsp;<span style='cursor:pointer;' class='btn btn-warning shadow btn-xs sharp me-1' data-hover='tooltip' ".$data." onclick='print_invoice(this.id);' data-id='".$mysqli->encode($id)."'  data-placement='top' title='Click here to print invoice form' id='".$id."' ><i class='fa fa-print'></i></span>";
					//$inv_btn = "&nbsp;<a href='".APPLICATION_URL."backend/invoice/".$invoice."'  download='' style='cursor:pointer;' class='btn btn-warning shadow btn-xs sharp me-1' data-hover='tooltip'   data-placement='top' title='Click here to print invoice' id='".$id."' ><i class='fa fa-print'></i></a>";
					$del_btn = "<span style='cursor: pointer;' class='btn btn-danger shadow btn-xs sharp' data-hover='tooltip' data-placement='top' title='Click here delete' id='del" . $rows['id'] . "' onclick='delete_rec(\"" . $rows['id'] . "\")'><i class='fa fa-trash'></i></span>";
					$up_btn = "<span style='cursor: pointer;' class='btn btn-secondary shadow btn-xs sharp' data-hover='tooltip' data-placement='top' title='Click here to upload declaration' id='up" . $rows['id'] . "' onclick='upload_dec(\"" . $rows['id'] . "\");'><i class='fa fa-upload'></i></span>";
					
					$down_btn = "<a href='".APPLICATION_URL."backend/uploads/declarations/".$declaration."'  download='' style='cursor: pointer;' class='btn btn-primary shadow btn-xs sharp' data-hover='tooltip' data-placement='top' title='Click here to download declaration'><i class='fa fa-download'></i></a>";
					
					$feeze_btn = "&nbsp;<span style='cursor: pointer;' class='btn btn-light shadow btn-xs sharp' data-hover='tooltip' data-placement='top' ".$data." onclick='freeze_popup(\"" . $rows['id'] . "\");' title='Click here to freeze' id='freeze" . $rows['id'] . "' ><i class='fa fa-lock'></i></span>";
					
					$renew_btn = "&nbsp;<span style='cursor: pointer;' class='btn btn-success shadow btn-xs sharp' data-hover='tooltip' data-placement='top' ".$data." onclick='renew_popup(\"" . $rows['id'] . "\");' title='Click here to renew membership' id='renew" . $rows['id'] . "' ><i class='fa fa-refresh' aria-hidden='true'></i></span>";

					

					$table .= "<tr>";
					$table .= "<td><nobr>".$i."</nobr></td>";
								
					$table .= "<td><nobr>";
					$table .= $btn;
					$table .= $del_btn;
					$table .= $dec_btn;
					if($membership_type == 'Single' || $membership_type == 'Family' && $family_head == '1'){
					$table .= $inv_btn;
					}
					if($declaration != ''){
					$table .= $down_btn;
					}else{
						$table .= $up_btn;
					}
					if($is_freezed != '1'){
					$table .= $feeze_btn;
					}
					if (($membership_type == 'Single' || ($membership_type == 'Family' && $family_head == '1')) && $status == 'Expired') {
					$table .= $renew_btn;
					}
					$table .="</nobr></td>";
					if($status == 'Active'){
					$status = '<span class="badge light badge-success badge-sm">'.$status.'</span>';
					}else{
					$status = '<span class="badge light badge-warning badge-sm">'.$status.'</span>';	
					}
					
					$member_id = '<span class="badge light badge-danger badge-sm">'.$member_id.'</span>';	
					
					$table .= "<td><center><nobr>".$status."</nobr></center></td>";		
					if($payment_status == 'Paid'){
					$payment_status = '<span class="badge light badge-success badge-sm">'.$payment_status.'</span>';
					}else{
					$payment_status = '<span class="badge light badge-warning badge-sm">'.$payment_status.'</span>';	
					}
					if($is_freezed == '1' &&  date('Y-m-d') <= $membership_freezed_till ){
					$freezed = '<br><span class="badge light badge-warning badge-sm">Freezed till '.$membership_freezed_till.'</span>';	
					}else{
						$freezed = '';
					}
					$table .= "<td><center><nobr>".$payment_status."</nobr></center></td>";
					$table .= "<td><center><nobr>".$member_id."</nobr></center></td>";		
					$table .= '<td><nobr><div class="d-flex align-items-center">
						<img src="uploads/profile/'.$picture.'" class="rounded-lg me-2" width="60" alt="">
						<span class="w-space-no">'.$name.' '.$freezed.'
					</div></nobr></td>';
					//$table .= "<td><nobr>".$email."</nobr></td>";
					$table .= "<td><nobr>".$mobile."</nobr></td>";					
					$table .= "<td><nobr>".$gender."</nobr></td>";					
					$table .= "<td><nobr>".$plan_details['title']."</nobr></td>";					
					$table .= "<td><nobr>".$timing."</nobr></td>";					
					$table .= "<td><nobr>".$start_date."</nobr></td>";					
					$table .= "<td><nobr>".$end_date."</nobr></td>";	
										
					$table .= "<td><center><nobr>".$payment_mode."</nobr></center></td>";					
					if($_SESSION['user_type'] == 'SUPERADMIN'){
					$table .= "<td><center><nobr>".$discounted_price."</nobr></center></td>";
					}			
					$table .= "<td><nobr>".$mysqli->formatdate($created_on,"j-M-Y h:i:A")."</nobr></td>";							
					$n++;
					$data = "";
				}
			}
			$table .= '</tbody></table></div>';	
			$table .= '<div style="background-color:#fff;" class="card-footer">';				
			$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
			$table .= '</div>';	
	}

	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No record found.</div></div>';
	}
}
if ($tab == 'view_recent_visitors')
{
	$con = "";
	if (!isset($sort_param))
    $sort_param = "id";

	if (!isset($page) || $page < 1) {
		$page = 1;
	}

	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}

	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}

	if (isset($page)) {
		$start    = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page  = 1;
		$start = 1;
	}
		
	if (!empty($membership_id) || $membership_id != "") {
		$con .= " and member_id = '" . trim($membership_id) . "'";
	}
	if (!empty($att_date) || $att_date != "") {
		$con .= " and attendance_date = '" . trim($att_date) . "'";
	}else{
		$att_date = date('Y-m-d');
	$con .="and attendance_date = '".$att_date."'";
	}
	
	 $sql = "select * from ".ATTENDANCE." where 1 ".$con."  ORDER BY attendance_date DESC, sign_in DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".ATTENDANCE." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	$row = "";	 
	
	if($num > 0)
	{						
		$count             = $num;
		$no_of_paginations = ceil($count / $per_page);
		$cur_page          = $cur_page;
		$previous_btn      = true;
		$next_btn          = true;
		$first_btn         = true;
		$last_btn          = true;
	      
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3">
				<div class="form-group pull-left">
					<label for="input" class="control-label">Record Limit:<span></span></label>					
						<select name="record_limit_change" id="record_limit_change" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="120">120</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>			
					
				</div>
			</div>
			<div class="col-md-6"></div>

			<div class="col-md-3">
				<div class="form-group pull-right">
					<label for="input" class="control-label">Search:<span></span></label>					
					<input type="text" id="live_search" class="form-control" />				
				</div>
			</div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<div style="margin: 2px; float: left;"></div>
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead>
		<tr>
		<th><nobr>#</nobr></th>';
		$table .= '<th><nobr>Membership ID</nobr></th><th><nobr>Name</nobr></th>';			
		$table .= '
		<th><nobr>Date</nobr></th>
		<th><nobr>Sign In</nobr></th>
		<th><nobr>Sign Out</nobr></th>';
		
		$table .= '</tr>
		</thead>	
		<tbody id="tbody">';
			if($num>0)
			{
				$n = 1;
				$data = "";
				while($rows = $mysqli->fetch_assoc($result))
				{	 									
					$country_code = '';
					$i = ($start + $n);
				
				
					foreach($rows as $key => $value)
					{
						$data .= "data-".$key."='".$value."' ";											
					}
								
					extract($rows);
					$member_details = $mysqli->singleRowAssoc_new('*', MEMBERS, 'id = "'.$user_id.'"');
					
					

					$table .= "<tr>";
					$table .= "<td><nobr>".$i."</nobr></td>";
					
					
					$member_id = '<span class="badge light badge-success badge-sm">'.$member_details['member_id'].'</span>';	
					$table .= "<td><center><nobr>".$member_id."</nobr></center></td>";		
					$table .= '<td><nobr><div class="d-flex align-items-center">
						<img src="uploads/profile/'.$member_details['picture'].'" class="rounded-lg me-2" width="60" alt="">
						<span class="w-space-no">'.$member_details['name'].' 
					</div></nobr></td>';					
					$table .= "<td><nobr>".$attendance_date."</nobr></td>";					
					$table .= "<td><nobr>".$mysqli->formatdate($sign_in,"h:i:s A")."</nobr></td>";				
					if($sign_out == '00:00:00'){
						$sign_out = '<span class="badge light badge-danger badge-sm">Not Punched Out</span>';
					}else{
						$sign_out = $mysqli->formatdate($sign_out,"h:i:s A");
					}
					$table .= "<td><nobr>".$sign_out."</nobr></td>";								
					$n++;
					$data = "";
				}
			}
			$table .= '</tbody></table></div>';	
			$table .= '<div style="background-color:#fff;" class="card-footer">';				
			$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
			$table .= '</div>';	
	}

	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No record found.</div></div>';
	}
}
if ($tab == 'view_plans')
{
	$con = "";
	if (!isset($sort_param))
    $sort_param = "id";

	if (!isset($page) || $page < 1) {
		$page = 1;
	}

	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}

	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}

	if (isset($page)) {
		$start    = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page  = 1;
		$start = 1;
	}
	
	
	$sql = "select * from ".PLANS." where 1 ".$con." order by id DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".PLANS." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	$row = "";	 
	
	if($num > 0)
	{						
		$count             = $num;
		$no_of_paginations = ceil($count / $per_page);
		$cur_page          = $cur_page;
		$previous_btn      = true;
		$next_btn          = true;
		$first_btn         = true;
		$last_btn          = true;
	      
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3">
				<div class="form-group pull-left">
					<label for="input" class="control-label">Record Limit:<span></span></label>					
						<select name="record_limit_change" id="record_limit_change" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="120">120</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>			
					
				</div>
			</div>
			<div class="col-md-6"></div>

			<div class="col-md-3">
				<div class="form-group pull-right">
					<label for="input" class="control-label">Search:<span></span></label>					
					<input type="text" id="live_search" class="form-control" />				
				</div>
			</div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<div style="margin: 2px; float: left;"></div>
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead>
		<tr>
		<th><nobr>#</nobr></th>';
		
			$table .= '<th><nobr>Action</nobr></th>';
		
		$table .= '<th><nobr>Title</nobr></th>';		
		$table .= '<th><nobr>Plan type</nobr></th>';		
		$table .= '<th><nobr>Price</nobr></th>
		<th><nobr>Duration</nobr></th>
		</tr>
		</thead>	
		<tbody id="tbody">';
			if($num>0)
			{
				$n = 1;
				$data = "";
				while($rows = $mysqli->fetch_assoc($result))
				{	 									
					$country_code = '';
					$i = ($start + $n);
				
				
					foreach($rows as $key => $value)
					{
						$data .= "data-".$key."='".$value."' ";											
					}
								
					extract($rows);
					$btn = "&nbsp;<span style='cursor:pointer;' class='btn btn-primary shadow btn-xs sharp me-1' data-hover='tooltip' ".$data."  data-id='".$mysqli->encode($id)."'  data-placement='top' onclick='edit_plans(\"" . $rows['id'] . "\")' title='Click here edit' id='".$id."' ><i class='fa  fa-pencil'></i></span>";
					
					$del_btn = "<span style='cursor: pointer;' class='btn btn-danger shadow btn-xs sharp' data-hover='tooltip' data-placement='top' title='Click here delete' id='del" . $rows['id'] . "' onclick='delete_rec(\"" . $rows['id'] . "\")'><i class='fa fa-trash'></i></span>";

					$table .= "<tr>";
					$table .= "<td><nobr>".$i."</nobr></td>";
								
					$table .= "<td><nobr>";
					$table .= $btn;
					$table .= $del_btn;
					$table .="</nobr></td>";
					
					$table .= "<td><nobr>".$title."</nobr></td>";
					$table .= "<td><nobr>".$plan_type."</nobr></td>";					
					$table .= "<td><nobr>".$price."</nobr></td>";					
					$table .= "<td><nobr>".$duration."</nobr></td>";						
								
					//$table .= "<td><nobr>".$mysqli->formatdate($created_on,"j-M-Y h:i:A")."</nobr></td>";							
					$n++;
					$data = "";
				}
			}
			$table .= '</tbody></table></div>';	
			$table .= '<div style="background-color:#fff;" class="card-footer">';				
			$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
			$table .= '</div>';	
	}

	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No record found.</div></div>';
	}
}
if ($tab == 'view_enquiries')
{
	$con = "";
	if (!isset($sort_param))
    $sort_param = "id";

	if (!isset($page) || $page < 1) {
		$page = 1;
	}

	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}

	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}

	if (isset($page)) {
		$start    = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page  = 1;
		$start = 1;
	}
	
	
	$sql = "select * from ".ENQUIRIES." where 1 ".$con." order by id DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".ENQUIRIES." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	$row = "";	 
	
	if($num > 0)
	{						
		$count             = $num;
		$no_of_paginations = ceil($count / $per_page);
		$cur_page          = $cur_page;
		$previous_btn      = true;
		$next_btn          = true;
		$first_btn         = true;
		$last_btn          = true;
	      
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3">
				<div class="form-group pull-left">
					<label for="input" class="control-label">Record Limit:<span></span></label>					
						<select name="record_limit_change" id="record_limit_change" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="120">120</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>			
					
				</div>
			</div>
			<div class="col-md-6"></div>

			<div class="col-md-3">
				<div class="form-group pull-right">
					<label for="input" class="control-label">Search:<span></span></label>					
					<input type="text" id="live_search" class="form-control" />				
				</div>
			</div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<div style="margin: 2px; float: left;"></div>
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead>
		<tr>
		<th><nobr>#</nobr></th>';
		
		$table .= '<th><nobr>Name</nobr></th>';		
		$table .= '<th><nobr>Email</nobr></th>';		
		$table .= '<th><nobr>Phone</nobr></th>
		<th><nobr>Message</nobr></th>
		<th><nobr>Enquired Received On</nobr></th>
		</tr>
		</thead>	
		<tbody id="tbody">';
			if($num>0)
			{
				$n = 1;
				$data = "";
				while($rows = $mysqli->fetch_assoc($result))
				{	 									
					$country_code = '';
					$i = ($start + $n);
				
				
					foreach($rows as $key => $value)
					{
						$data .= "data-".$key."='".$value."' ";											
					}
								
					extract($rows);
					$btn = "&nbsp;<span style='cursor:pointer;' class='btn btn-primary shadow btn-xs sharp me-1' data-hover='tooltip' ".$data."  data-id='".$mysqli->encode($id)."'  data-placement='top' onclick='edit_plans(\"" . $rows['id'] . "\")' title='Click here edit' id='".$id."' ><i class='fa  fa-pencil'></i></span>";
					
					$del_btn = "<span style='cursor: pointer;' class='btn btn-danger shadow btn-xs sharp' data-hover='tooltip' data-placement='top' title='Click here delete' id='del" . $rows['id'] . "' onclick='delete_rec(\"" . $rows['id'] . "\")'><i class='fa fa-trash'></i></span>";

					$table .= "<tr>";
					$table .= "<td><nobr>".$i."</nobr></td>";
								
					/* $table .= "<td><nobr>";
					$table .= $btn;
					$table .= $del_btn;
					$table .="</nobr></td>"; */
					
					$table .= "<td><nobr>".$name."</nobr></td>";
					$table .= "<td><nobr>".$email."</nobr></td>";					
					$table .= "<td><nobr>".$phone."</nobr></td>";					
					$table .= "<td><nobr>".$message."</nobr></td>";						
								
					$table .= "<td><nobr>".$mysqli->formatdate($recTimestamp,"j-M-Y h:i:A")."</nobr></td>";							
					$n++;
					$data = "";
				}
			}
			$table .= '</tbody></table></div>';	
			$table .= '<div style="background-color:#fff;" class="card-footer">';				
			$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
			$table .= '</div>';	
	}

	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No record found.</div></div>';
	}
}if ($tab == 'view_feedbacks')
{
	$con = "";
	if (!isset($sort_param))
    $sort_param = "id";

	if (!isset($page) || $page < 1) {
		$page = 1;
	}

	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}

	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}

	if (isset($page)) {
		$start    = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page  = 1;
		$start = 1;
	}
	
	
	$sql = "select * from tbl_feedback where 1 ".$con." order by id DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from tbl_feedback where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	$row = "";	 
	
	if($num > 0)
	{						
		$count             = $num;
		$no_of_paginations = ceil($count / $per_page);
		$cur_page          = $cur_page;
		$previous_btn      = true;
		$next_btn          = true;
		$first_btn         = true;
		$last_btn          = true;
	      
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3">
				<div class="form-group pull-left">
					<label for="input" class="control-label">Record Limit:<span></span></label>					
						<select name="record_limit_change" id="record_limit_change" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="120">120</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>			
					
				</div>
			</div>
			<div class="col-md-6"></div>

			<div class="col-md-3">
				<div class="form-group pull-right">
					<label for="input" class="control-label">Search:<span></span></label>					
					<input type="text" id="live_search" class="form-control" />				
				</div>
			</div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<div style="margin: 2px; float: left;"></div>
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead>
		<tr>
		<th><nobr>#</nobr></th>';
		
		$table .= '<th><nobr>Name</nobr></th>';			
		$table .= '
		<th><nobr>Feedback</nobr></th>
		<th><nobr>Feedback Received On</nobr></th>
		</tr>
		</thead>	
		<tbody id="tbody">';
			if($num>0)
			{
				$n = 1;
				$data = "";
				while($rows = $mysqli->fetch_assoc($result))
				{	 									
					$country_code = '';
					$i = ($start + $n);
				
				
					foreach($rows as $key => $value)
					{
						$data .= "data-".$key."='".$value."' ";											
					}
								
					extract($rows);
					$btn = "&nbsp;<span style='cursor:pointer;' class='btn btn-primary shadow btn-xs sharp me-1' data-hover='tooltip' ".$data."  data-id='".$mysqli->encode($id)."'  data-placement='top' onclick='edit_plans(\"" . $rows['id'] . "\")' title='Click here edit' id='".$id."' ><i class='fa  fa-pencil'></i></span>";
					
					$del_btn = "<span style='cursor: pointer;' class='btn btn-danger shadow btn-xs sharp' data-hover='tooltip' data-placement='top' title='Click here delete' id='del" . $rows['id'] . "' onclick='delete_rec(\"" . $rows['id'] . "\")'><i class='fa fa-trash'></i></span>";

					$table .= "<tr>";
					$table .= "<td><nobr>".$i."</nobr></td>";
								
					/* $table .= "<td><nobr>";
					$table .= $btn;
					$table .= $del_btn;
					$table .="</nobr></td>"; */
					
					$table .= "<td><nobr>".$name."</nobr></td>";				
					$table .= "<td><nobr>".$message."</nobr></td>";						
								
					$table .= "<td><nobr>".$mysqli->formatdate($recTimestamp,"j-M-Y h:i:A")."</nobr></td>";							
					$n++;
					$data = "";
				}
			}
			$table .= '</tbody></table></div>';	
			$table .= '<div style="background-color:#fff;" class="card-footer">';				
			$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
			$table .= '</div>';	
	}

	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No record found.</div></div>';
	}
}if ($tab == 'view_sent_notifications')
{
	$con = "";
	if (!isset($sort_param))
    $sort_param = "id";

	if (!isset($page) || $page < 1) {
		$page = 1;
	}

	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}

	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}

	if (isset($page)) {
		$start    = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page  = 1;
		$start = 1;
	}
	
	
	$sql = "select * from ".NOTIFICATIONS." where 1 ".$con." order by id DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql) ; 
	 
	
	$sql123 = "select count(id) as count_rows from ".NOTIFICATIONS." where 1 ".$con;
	$result123 = $mysqli->executeQry($sql123) ; 
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	$row = "";	 
	
	if($num > 0)
	{						
		$count             = $num;
		$no_of_paginations = ceil($count / $per_page);
		$cur_page          = $cur_page;
		$previous_btn      = true;
		$next_btn          = true;
		$first_btn         = true;
		$last_btn          = true;
	      
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3">
				<div class="form-group pull-left">
					<label for="input" class="control-label">Record Limit:<span></span></label>					
						<select name="record_limit_change" id="record_limit_change" class="form-control">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="120">120</option>
							<option value="150">150</option>
							<option value="200">200</option>
						</select>			
					
				</div>
			</div>
			<div class="col-md-6"></div>

			<div class="col-md-3">
				<div class="form-group pull-right">
					<label for="input" class="control-label">Search:<span></span></label>					
					<input type="text" id="live_search" class="form-control" />				
				</div>
			</div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<div style="margin: 2px; float: left;"></div>
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead>
		<tr>
		<th><nobr>#</nobr></th>';
			
		$table .= '<th><nobr>Email</nobr></th>	
		<th><nobr>Sent On</nobr></th>
		</tr>
		</thead>	
		<tbody id="tbody">';
			if($num>0)
			{
				$n = 1;
				$data = "";
				while($rows = $mysqli->fetch_assoc($result))
				{	 									
					$country_code = '';
					$i = ($start + $n);
				
				
					foreach($rows as $key => $value)
					{
						$data .= "data-".$key."='".$value."' ";											
					}
								
					extract($rows);

					$table .= "<tr>";
					$table .= "<td><nobr>".$i."</nobr></td>";
								
					$table .= "<td><nobr>".$email."</nobr></td>";
					$table .= "<td><nobr>".$mysqli->formatdate($sent_on,"j-M-Y h:i:A")."</nobr></td>";							
					$n++;
					$data = "";
				}
			}
			$table .= '</tbody></table></div>';	
			$table .= '<div style="background-color:#fff;" class="card-footer">';				
			$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
			$table .= '</div>';	
	}

	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No record found.</div></div>';
	}
}


if ($tab == 'view_whatsapp_logs')
{
	$mysqli->whatsappRunMigration();
	if (!isset($page) || $page < 1) {
		$page = 1;
	}
	if (!isset($disp_rec) || $disp_rec == "") {
		$disp_rec = 10;
		$per_page = 10;
	}
	if (isset($record_limit)) {
		$disp_rec = $record_limit;
		$per_page = $disp_rec;
	}
	if (isset($page)) {
		$start = (($page - 1) * $disp_rec);
		$cur_page = $page;
	} else {
		$page = 1;
		$start = 1;
	}
	$sql = "select * from ".WHATSAPP_LOGS." where 1 order by id DESC limit ".$start.",".$disp_rec;
	$result = $mysqli->executeQry($sql);
	$result123 = $mysqli->executeQry("select count(id) as count_rows from ".WHATSAPP_LOGS." where 1");
	$num_arr = $mysqli->fetch_array($result123);
	$num = $num_arr['count_rows'];
	if($num > 0)
	{
		$no_of_paginations = ceil($num / $per_page);
		$previous_btn = true;
		$next_btn = true;
		$first_btn = true;
		$last_btn = true;
		$table = '
		<div class="card-body"><div class="row">
			<div class="col-md-3"><div class="form-group pull-left"><label class="control-label">Record Limit:<span></span></label>
				<select name="record_limit_change" id="record_limit_change" class="form-control">
					<option value="10">10</option><option value="20">20</option><option value="30">30</option><option value="50">50</option><option value="100">100</option><option value="200">200</option>
				</select></div></div>
			<div class="col-md-6"></div>
			<div class="col-md-3"><div class="form-group pull-right"><label class="control-label">Search:<span></span></label><input type="text" id="live_search" class="form-control" /></div></div>
		</div>
		<input type="hidden" id="total_records" value="'.$num.'">
		<table id="dynamic_table" class="table table-bordered table-hover table-responsive-sm">
		<thead><tr>
		<th><nobr>#</nobr></th>
		<th><nobr>Status</nobr></th>
		<th><nobr>Mobile</nobr></th>
		<th><nobr>Member ID</nobr></th>
		<th><nobr>Template</nobr></th>
		<th><nobr>Type</nobr></th>
		<th><nobr>Error</nobr></th>
		<th><nobr>API Response</nobr></th>
		<th><nobr>Created On</nobr></th>
		</tr></thead><tbody id="tbody">';
		$n = 1;
		while($rows = $mysqli->fetch_assoc($result))
		{
			$i = ($start + $n);
			$status_class = 'badge-warning';
			if($rows['status'] == 'Sent') $status_class = 'badge-success';
			if($rows['status'] == 'Failed') $status_class = 'badge-danger';
			if($rows['status'] == 'Skipped') $status_class = 'badge-secondary';
			$table .= "<tr>";
			$table .= "<td><nobr>".$i."</nobr></td>";
			$table .= "<td><span class='badge light ".$status_class." badge-sm'>".$rows['status']."</span></td>";
			$table .= "<td><nobr>".$rows['mobile']."</nobr></td>";
			$table .= "<td><nobr>".$rows['member_id']."</nobr></td>";
			$table .= "<td><nobr>".$rows['template_name']."</nobr></td>";
			$table .= "<td><nobr>".$rows['message_type']."</nobr></td>";
			$table .= "<td><nobr>".htmlspecialchars(substr($rows['error_message'], 0, 180))."</nobr></td>";
			$table .= "<td><nobr>".htmlspecialchars(substr($rows['response_payload'], 0, 220))."</nobr></td>";
			$table .= "<td><nobr>".$mysqli->formatdate($rows['created_on'],"j-M-Y h:i:A")."</nobr></td>";
			$table .= "</tr>";
			$n++;
		}
		$table .= '</tbody></table></div>';
		$table .= '<div style="background-color:#fff;" class="card-footer">';
		$table .= $mysqli->custompaging_table_response($cur_page, $no_of_paginations, $previous_btn, $next_btn, $first_btn, $last_btn);
		$table .= '</div>';
	}
	else
	{
		$table = '<div class="card-body"><div class="alert alert-danger"><strong>!!</strong> No WhatsApp log found.</div></div>';
	}
}



echo $table ;


	
