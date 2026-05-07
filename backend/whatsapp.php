<?php
$pagecode = "PO-009";
include 'includes/check_session.php';
$pageno = 1;
$mysqli->whatsappRunMigration();
$templates = $mysqli->executeQry("SELECT * FROM ".WHATSAPP_TEMPLATES." ORDER BY id DESC");
$approved_templates = $mysqli->executeQry("SELECT * FROM ".WHATSAPP_TEMPLATES." WHERE status = 'Approved' ORDER BY template_name ASC");
$members = $mysqli->executeQry("SELECT id, member_id, name, mobile, status FROM ".MEMBERS." WHERE (membership_type = 'Single' OR (membership_type = 'Family' AND family_head = '1')) ORDER BY name ASC");
$wallet = $mysqli->whatsappGetWalletBalance();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php require_once("includes/header.php"); ?>
	<title>WhatsApp | <?php echo APPLICATION_NAME; ?> </title>
	<?php require_once("includes/sidebar.php"); ?>
	<link rel="stylesheet" href="vendor/select2/css/select2.min.css">
	<style>
		textarea.form-control { min-height: 150px !important; }
		.template-example { background:#f8f9fa; border:1px solid #e7e7e7; padding:12px; margin-bottom:10px; border-radius:4px; }
	</style>
	<div class="content-body">
		<div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0);">WhatsApp</a></li>
			</ol>
		</div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-4 col-md-6">
					<div class="card">
						<div class="card-body">
							<div class="d-flex align-items-center justify-content-between">
								<div>
									<p class="mb-1 text-muted">WhatsApp Wallet Balance</p>
									<h3 class="mb-0"><?php echo ($wallet['success'] && $wallet['balance'] !== '') ? htmlspecialchars(number_format((float)$wallet['balance'], 2)) : 'Unavailable'; ?></h3>
									<?php if (!$wallet['success']) { ?><small class="text-danger"><?php echo htmlspecialchars($wallet['error']); ?></small><?php } ?>
								</div>
								<div class="menu-icon" style="width:46px;height:46px;background:#4b5563;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#fff;">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
										<path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93a7.898 7.898 0 0 0-2.327-5.607zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592z"/>
									</svg>
								</div>
							</div>
							<small class="text-muted d-block mt-2">Fetched from dgasskyworld wallet API.</small>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6">
					<div class="card">
						<div class="card-header"><h5 class="heading mb-0">Create WhatsApp Template</h5></div>
						<div class="card-body">
							<div class="alert alert-warning">Offer, discount, promotion, or campaign messages are treated as Marketing templates and should not be created under Utility.</div>
							<div class="alert alert-info">Saving this form submits a text BODY template to the dgasskyworld API. Create only text templates here.</div>
							<form method="POST" id="frm_whatsapp_template" class="whatsapp-ajax-form" onsubmit="return false;">
								<div class="mb-3">
									<label class="form-label">Template Title</label>
									<input type="text" name="template_name" class="form-control" required>
								</div>
								<div class="mb-3">
									<label class="form-label">Provider Template Name</label>
									<input type="text" name="provider_template_name" id="provider_template_name" class="form-control nospace" pattern="[a-z]{1,15}" maxlength="15" required>
									<small>Use only lowercase alphabetic characters a-z. No spaces, numbers, or special characters. Maximum 15 characters. Example: welcome</small>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="form-label">Category</label>
										<select name="category" class="form-control default-select">
											<option value="Utility">Utility</option>
											<option value="Marketing">Marketing</option>
										</select>
									</div>
									<div class="col-md-6 mb-3">
										<label class="form-label">Language Code</label>
										<input type="text" name="language_code" value="en" class="form-control" required>
									</div>
								</div>
								<div class="mb-3">
									<label class="form-label">Template Body</label>
									<textarea name="template_body" class="form-control" required></textarea>
									<small>Use placeholders like {{user_name}}, {{mobile}}, {{expiry_date}}, {{plan_name}}, {{company_name}}. The API request converts these to provider placeholders like {{1}}, {{2}} with examples.</small>
								</div>
								<input type="hidden" name="tab" value="add_whatsapp_template">
								<input type="hidden" name="url" value="<?php echo "index.php?".$mysqli->encode("stat=ajax"); ?>">
								<button type="submit" class="btn btn-primary">Save Template</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-xl-6">
					<div class="card">
						<div class="card-header"><h5 class="heading mb-0">Template Examples</h5></div>
						<div class="card-body">
							<div class="template-example"><b>Utility: Membership created</b><br>Welcome to Swim Gym Academy, {{user_name}}.<br>Your membership has been created successfully. Membership ID: {{member_id}}. Plan Name: {{plan_name}}. Start Date: {{start_date}}. Expiry Date: {{expiry_date}}. Class Timing: {{timing}}. Please keep this message for your records. Thank you for choosing Swim Gym Academy.</div>
							<div class="template-example"><b>Utility: Expiring today reminder</b><br>Hello {{user_name}}, your {{company_name}} plan {{plan_name}} expires today on {{expiry_date}}.</div>
							<div class="template-example"><b>Utility: Service update</b><br>Hello {{user_name}}, important update from {{company_name}}: {{message}}</div>
							<div class="template-example"><b>Marketing: Offer/promotion</b><br>Hello {{user_name}}, get a special discount on {{plan_name}} at {{company_name}}.</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h5 class="heading mb-0">Sync Templates From Provider</h5></div>
				<div class="card-body">
					<form method="POST" id="frm_whatsapp_sync" class="whatsapp-ajax-form mb-3" onsubmit="return false;">
						<input type="hidden" name="tab" value="sync_whatsapp_templates">
						<input type="hidden" name="url" value="<?php echo "index.php?".$mysqli->encode("stat=ajax"); ?>">
						<button type="submit" class="btn btn-info btn-sm">Sync Provider Template List</button>
						<small class="ms-2">Imports all provider templates and updates Pending/Approved/Rejected statuses automatically.</small>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h5 class="heading mb-0">Send WhatsApp Message</h5></div>
				<div class="card-body">
					<form method="POST" id="frm_whatsapp_bulk" class="whatsapp-ajax-form" onsubmit="return false;">
						<div class="row">
							<div class="col-md-4 mb-3">
								<label class="form-label">Approved Template</label>
								<select name="template_id" class="form-control default-select" required>
									<option value="">Select approved template</option>
									<?php while($tpl = $mysqli->fetch_assoc($approved_templates)) { ?>
										<option value="<?php echo $tpl['id']; ?>"><?php echo htmlspecialchars($tpl['template_name']); ?> (<?php echo htmlspecialchars($tpl['category']); ?>)</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3 mb-3">
								<label class="form-label">Send To</label>
								<select name="audience" id="audience" class="form-control default-select" required>
									<option value="Active">Active users</option>
									<option value="Inactive">Inactive users</option>
									<option value="All">All users</option>
									<option value="Selected">Selected users</option>
								</select>
							</div>
							<div class="col-md-5 mb-3" id="selected_users_div" style="display:none;">
								<label class="form-label">Selected Users</label>
								<select name="selected_users[]" id="selected_users" class="form-control" multiple>
									<?php while($member = $mysqli->fetch_assoc($members)) { ?>
										<option value="<?php echo $member['id']; ?>"><?php echo htmlspecialchars($member['name'].' | '.$member['member_id'].' | '.$member['mobile'].' | '.$member['status']); ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<input type="hidden" name="tab" value="send_whatsapp_bulk">
						<input type="hidden" name="url" value="<?php echo "index.php?".$mysqli->encode("stat=ajax"); ?>">
						<button type="submit" class="btn btn-success">Queue WhatsApp Batch</button>
						<span class="text-muted ms-2">Batch cron sends <?php echo WHATSAPP_BATCH_SIZE; ?> messages per run.</span>
					</form>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h5 class="heading mb-0">WhatsApp Templates</h5></div>
				<div class="card-body table-responsive">
					<table class="table table-bordered table-hover table-responsive-sm">
						<thead><tr><th>#</th><th>Title</th><th>Provider Name</th><th>Category</th><th>Status</th><th>Body</th><th>Response/Error</th></tr></thead>
						<tbody>
						<?php mysqli_data_seek($templates, 0); $i = 1; while($tpl = $mysqli->fetch_assoc($templates)) { ?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td><?php echo htmlspecialchars($tpl['template_name']); ?></td>
								<td><?php echo htmlspecialchars($tpl['provider_template_name']); ?></td>
								<td><?php echo htmlspecialchars($tpl['category']); ?></td>
								<td><?php echo htmlspecialchars($tpl['status']); ?></td>
								<td><?php echo htmlspecialchars($tpl['body']); ?></td>
								<td><?php echo htmlspecialchars($tpl['api_response']); ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<form onsubmit="return false;" id="frm_search" method="post">
				<input type='hidden' name='tab' value="<?php echo 'view_whatsapp_logs'; ?>" />
				<input type="hidden" name="url" id="url" value="<?php echo "index.php?".$mysqli->encode("stat=table_response"); ?>" required>
				<input type="hidden" name="record_limit" id="record_limit" value="10">
				<input type="hidden" name="page" id="page" value="<?php echo $pageno; ?>">
			</form>
			<div class="card">
				<div class="card-header">
					<h5 class="heading mb-0">WhatsApp Sent/Failed Logs</h5>
					<div class="card-tools" style="display:none;">
						Reloading in (Seconds): <span style="color:#fff;font-weight:bold" id='timee'></span>
						<a href="javascript:void(0)"><i class="fa fa-pause icon-lg" aria-hidden="true" id="timercontroller" onclick="stoptimer()" title="Pause"></i></a>
					</div>
				</div>
				<div id="dynamic_div" class="table-responsive"><div class="card-body"></div></div>
			</div>
		</div>
	</div>
<?php
include_once("includes/footer.php");
include_once("includes/dynamic_table.php");
?>
	<script src="vendor/select2/js/select2.full.min.js"></script>
	<script src="js/cms.js"></script>
	<script src="js/plugins-init/select2-init.js"></script>
	<script>
		$(document).ready(function() {
			$('#selected_users').select2();
			$('#audience').on('change', function() {
				if ($(this).val() == 'Selected') {
					$('#selected_users_div').show();
				} else {
					$('#selected_users_div').hide();
				}
			});
			$(document).on('submit', '.whatsapp-ajax-form', function(e) {
				e.preventDefault();
				send_ajax_request(this.id, '', 'N');
			});
			$('#provider_template_name').on('input', function() {
				this.value = this.value.toLowerCase().replace(/[^a-z]+/g, '').substring(0, 15);
			});
		});
	</script>
	</body>
</html>
