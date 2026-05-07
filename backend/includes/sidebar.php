<?php
if (!defined('ABSOLUTE_ROOT_PATH')) {
	echo "<script>location.href='../error_403.php'</script>";
	exit;
}
?>
<!--**********************************Sidebar start ***********************************-->
<div class="deznav">
	<div class="deznav-scroll">
		<ul class="metismenu mm-show" id="menu">
			<!--<li class="menu-title">YOUR COMPANY</li>-->
			<?php if ($_SESSION['user_type'] == 'SUPERADMIN' || $_SESSION['user_type'] == 'ADMIN') { ?>
			<?php $href = 'index.php?'.$mysqli->encode("stat=Dashboard");?>
				<li class="<?php if($stat == 'Dashboard') echo 'mm-active' ?>"><a href="<?php echo $href;?>" aria-expanded="false">
						<div <?php if ($stat == 'Dashboard') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M2.5 7.49999L10 1.66666L17.5 7.49999V16.6667C17.5 17.1087 17.3244 17.5326 17.0118 17.8452C16.6993 18.1577 16.2754 18.3333 15.8333 18.3333H4.16667C3.72464 18.3333 3.30072 18.1577 2.98816 17.8452C2.67559 17.5326 2.5 17.1087 2.5 16.6667V7.49999Z" stroke="#888888" stroke-linecap="round" stroke-linejoin="round" />
								<path d="M7.5 18.3333V10H12.5V18.3333" stroke="#888888" stroke-linecap="round" stroke-linejoin="round" />
							</svg>
						</div>
						<span class="nav-text">Dashboard</span>
					</a>
				</li>
				<?php } ?>
				<?php if ($_SESSION['user_type'] == 'SUPERADMIN') { ?>
				<li class="<?php if ($stat == 'plans') echo 'mm-active' ?>">
				<?php $href_1 = 'index.php?'.$mysqli->encode("stat=plans");?>
					<a href="<?php echo $href_1;?>">
						<div <?php if ($stat == 'plans') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">

								<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
								<path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
							</svg>
						</div>
						<span class="nav-text">Plans</span>
					</a>
					
				</li>
				<?php } ?>
				<?php if ($_SESSION['user_type'] == 'SUPERADMIN' || $_SESSION['user_type'] == 'ADMIN') { ?>
				<li class="<?php if ($stat == 'users') echo 'mm-active' ?>">
				<?php $href_1 = 'index.php?'.$mysqli->encode("stat=users");?>
					<a href="<?php echo $href_1;?>">
						<div <?php if ($stat == 'users') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
								<path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8Zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022ZM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0ZM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816ZM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" />
							</svg>
						</div>
						<span class="nav-text">Members</span>
					</a>
					
				</li>
				<li class="<?php if ($stat == 'enquiry') echo 'mm-active' ?>">
				<?php $href_1 = 'index.php?'.$mysqli->encode("stat=enquiry");?>
					<a href="<?php echo $href_1;?>">
						<div <?php if ($stat == 'enquiry') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-help-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
								<path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
								<path d="M12 16v.01" />
								<path d="M12 13a2 2 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
							</svg>
						</div>
						<span class="nav-text">Enquiries</span>
					</a>
					
				</li><li class="<?php if ($stat == 'feedback') echo 'mm-active' ?>">
				<?php $href_f = 'index.php?'.$mysqli->encode("stat=feedback");?>
					<a href="<?php echo $href_f;?>">
						<div <?php if ($stat == 'feedback') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M2.87187 11.5983C1.79887 8.24832 3.05287 4.41932 6.56987 3.28632C8.41987 2.68932 10.4619 3.04132 11.9999 4.19832C13.4549 3.07332 15.5719 2.69332 17.4199 3.28632C20.9369 4.41932 22.1989 8.24832 21.1269 11.5983C19.4569 16.9083 11.9999 20.9983 11.9999 20.9983C11.9999 20.9983 4.59787 16.9703 2.87187 11.5983Z" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M16 6.70001C17.07 7.04601 17.826 8.00101 17.917 9.12201" stroke="#130F26" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
						</div>
						<span class="nav-text">Feedbacks</span>
					</a>
					
				</li>
				<?php } ?>
				<?php if ($_SESSION['user_type'] == 'SUPERADMIN' || $_SESSION['user_type'] == 'ADMIN') { ?>
			<li class="<?php if ($stat == 'messages') echo 'mm-active' ?>">
				<?php $href_1 = 'index.php?'.$mysqli->encode("stat=messages");?>
					<a href="<?php echo $href_1;?>">
						<div <?php if ($stat == 'messages') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path d="M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
										<path d="M13.73 21C13.5542 21.3031 13.3019 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21" stroke="white" stroke-linecap="round" stroke-linejoin="round"></path>
									</svg>
						</div>
						<span class="nav-text">Send Notifications</span>
					</a>
					
				</li>
			<li class="<?php if ($stat == 'whatsapp') echo 'mm-active' ?>">
				<?php $href_wa = 'index.php?'.$mysqli->encode("stat=whatsapp");?>
					<a href="<?php echo $href_wa;?>">
						<div <?php if ($stat == 'whatsapp') echo "style='background:#0d99ff'" ?> class="menu-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
								<path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93a7.898 7.898 0 0 0-2.327-5.607zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
							</svg>
						</div>
						<span class="nav-text">WhatsApp</span>
					</a>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>

<!--
**********************************
Sidebar end
***********************************
-->
