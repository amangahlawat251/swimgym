<?php    
require_once('backend/includes/constant.php');
require_once('backend/includes/autoload.php');
$mysqli = new MySqliDriver();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">

    <!-- ===== Mobile viewport optimized ===== -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0, user-scalable=no">

    <!-- ===== Meta Tags - Description for Search Engine purposes ===== -->
   <meta name="description" content="Swim Gym Academy in Rohtak offers top-notch swimming pool facilities. Join us for a healthy lifestyle!">
	<meta name="keywords" content="swimming pool, gym, yoga, sauna, fitness, Rohtak, swimming pool in rohtak">
    <meta name="author" content="swimgymacademy">
	<meta name="robots" content="index, follow">


    <!-- ===== Website Title ===== -->
   <title>Swim Gym Academy - Rohtak's Premier Swimming Pool</title>

    <link rel="shortcut icon" href="<?php echo FAVICON_PATH;?>" type="image/x-icon">
    <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.html">

    <!-- ===== Google Fonts ===== -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Open+Sans" rel="stylesheet">

    <!-- ===== CSS links ===== -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/shuffle.css">
    <link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">
	<link href="<?php echo  APPLICATION_URL; ?>vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<style>
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(255, 255, 255, 0.2);
  border-right: 1.1em solid rgba(255, 255, 255, 0.2);
  border-bottom: 1.1em solid rgba(255, 255, 255, 0.2);
  border-left: 1.1em solid #5A8DEE;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

.loader {
    top: calc(50vh - 100px);
}

#loader {  
    position: fixed;  
    left: 0px;  
    top: 0px;  
    width: 100%;  
    height: 100%;  
    z-index: 9999;  
    background: #00000040;  
} 
.attractive-text {
           background: #48c1eb;
    background-clip: border-box;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  transition: transform 0.3s, text-shadow 0.3s;
}
        }
        .attractive-text:hover {
            transform: scale(1.1);
            text-shadow: 3px 3px 7px rgba(0, 0, 0, 0.5);
        }
		#main-footer {
    background-color: #f8f8f8;
    padding: 40px 0;
}

.footer-top {
    margin-bottom: 20px;
}

.about ul {
    list-style: none;
    padding: 0;
}

.about ul li {
    margin-bottom: 10px;
}

.footer-social h4 {
    margin-bottom: 20px;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-flex;
}

.footer-links li {
    margin: 0 3px;
}

.footer-links a {
    text-decoration: none;
    color: #f6f8f8;
    font-size: 20px;
    display: inline-block;
    position: relative;
    transition: transform 0.3s ease-in-out;
}

.footer-links a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    width: 0;
    height: 2px;
    background-color: #333;
    transition: width 0.3s ease-in-out;
    transform: translateX(-50%);
}

.footer-links a:hover {
    transform: translateY(-10px);
	text-decoration: none;
	color:#3cbeee;
}


.copyright {
    margin-top: 20px;
}
.map-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
    height: 0;
    overflow: hidden;
    max-width: 100%;
    background: #f8f8f8;
}

.map-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}
</style>
<body>

<div id="loader"><div class="loader">Loading...</div></div>
    <!-- ===== Start of Header ===== -->
    <header class="main">
        <nav class="navbar navbar-default navbar-static-top fluid_header">
            <div class="container">

                <!-- Logo -->
                <div class="col-md-4">
                    <a class="navbar-brand" href="javascript:void(0);"><img src="<?php echo LOGO_PATH;?>" alt="logo"></a>
                    <!-- INSERT YOUR LOGO HERE -->
                </div>

                
            </div>
        </nav>
    </header>
    <!-- ===== End of Header ===== -->



    <!-- ===== Main Section ===== -->
    <section class="main" id="home">
        <!-- Fullscreen -->
        <div class="fullscreen overlay" id="index-image">

            <!-- Content -->
            <div class="slider-content container">
                <div class="col-md-12">
                    <h3>Welcome to <br> <span>Swim Gym Academy</span></h3>
                    <h4>The place where you always be <span>young</span>!</h4>
                    <div class="cta">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#contact_us" class="btn">Join now</a>
                    </div>
                </div>
            </div>
            <!-- End of Content -->

            <!-- scroll down -->
            <div class="scroll-down"><a href="#about-us"><i class="fa fa-angle-double-down"></i></a></div>

        </div>
        <!-- End of Fullscreen Container -->
    </section>
    <!-- ===== End of Main Section ===== -->



    <!-- ===== Start About Us Section ===== -->
    <section id="about-us">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-4 about-image">
                </div>

                <div class="col-md-8 main-content">
                    <h2 class="section-title">About Us</h2>
                    <div class="about-description">
                        <p>Welcome to "Swim Gym Academy", where passion meets expertise in the world of swimming! Our academy is dedicated to nurturing swimmers of all ages and skill levels, providing personalized coaching and a supportive community. Our experienced instructors focus on safety, technique, and confidence-building to help each swimmer reach their potential. Whether you're just starting out or aiming for competitive success, join us to make a splash in the pool and create lasting memories!</p>
                        
                    </div>
                </div>

                <div class="logo-overlay">
                </div>

            </div>
        </div>
    </section>
    <!-- ===== End About Us Section ===== -->



    <!-- ===== Start of Gallery Section ===== -->
    <section id="gallery">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pad80">
                    <h2 class="section-title">Gallery</h2>
                </div>

                <!-- Start of Gallery Filters -->
                <ul class="gallery-sorting text-center">
                    <li><a href="javascript:void(0);" class="btn-border active" data-group="all">All</a></li>
                    <li><a href="javascript:void(0);" class="btn-border" data-group="indoor">Indoor</a></li>
                    <li><a href="javascript:void(0);" class="btn-border" data-group="outdoor">Outdoor</a></li>
                </ul>
                <!-- End of Gallery Filters -->

                <!-- Start of Gallery Images -->
                <ul class="gallery-items list-unstyled" id="grid">

                    <!-- image 1 -->
                    <li class="col-md-2 col-sm-4 col-xs-6" data-groups='["indoor"]'>
                        <figure class="gallery-item">
                            <a href="images/img/DSC_0371.jpg">
                                <img src="images/img/DSC_0371.jpg" alt="" class="img-responsive">
                            </a>
                        </figure>
                    </li>

                    <!-- image 2 -->
                    <li class="col-md-2 col-sm-4 col-xs-6" data-groups='["outdoor"]'>
                        <figure class="gallery-item">
                            <a href="images/img/DSC_0319.jpg">
                                <img src="images/img/DSC_0319.jpg" alt="" class="img-responsive">
                            </a>
                        </figure>
                    </li>

                    <!-- image 3 -->
                    <li class="col-md-2 col-sm-4 col-xs-6" data-groups='["indoor"]'>
                        <figure class="gallery-item">
                            <a href="images/img/DSC_0344.jpg">
                                <img src="images/img/DSC_0344.jpg" alt="" class="img-responsive">
                            </a>
                        </figure>
                    </li>

                    <!-- image 4 -->
                    <li class="col-md-2 col-sm-4 col-xs-6" data-groups='["outdoor"]'>
                        <figure class="gallery-item">
                            <a href="images/img/DSC_0318.jpg">
                                <img src="images/img/DSC_0318.jpg" alt="" class="img-responsive">
                            </a>
                        </figure>
                    </li>

                    <!-- image 5 -->
                    <li class="col-md-2 col-sm-4 col-xs-6" data-groups='["outdoor"]'>
                        <figure class="gallery-item">
                            <a href="images/img/DSC_0381.jpg">
                                <img src="images/img/DSC_0381.jpg" alt="" class="img-responsive">
                            </a>
                        </figure>
                    </li>

                    <!-- image 7 -->
                    <li class="col-md-2 col-sm-4 col-xs-6" data-groups='["indoor"]'>
                        <figure class="gallery-item">
                            <a href="images/img/DSC_0326.jpg">
                                <img src="images/img/DSC_0326.jpg" alt="" class="img-responsive">
                            </a>
                        </figure>
                    </li>

                   
                </ul>
                <!-- End of Gallery Images -->

            </div>
        </div>
    </section>
    <!-- ===== End of Gallery Section ===== -->




    <!-- ===== Start of CountUp Section ===== -->
    <section id="countup">
        <div class="container main-content">
            <div class="col-md-12">

               
                <!-- 2nd Count up item -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <img src="images/icons/happy.svg" alt="">
                    <h3>Happy Clients</h3>
                    <span class="counter" data-from="0" data-to="150"></span>
                </div>
                <!-- End of 2nd Count up item -->

                <!-- 3rd Count up item -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <img src="images/icons/swimmer.svg" alt="">
                    <h3>Daily Swimmmers</h3>
                    <span class="counter" data-from="0" data-to="75"></span>
                </div>
                <!-- End of 3rd Count up item -->

            </div>
        </div>
    </section>
    <!-- ===== End of CountUp Section ===== -->




    <!-- ===== Start of Blog Section ===== -->
    <section id="pricing">
        <div class="container main-content">
            <div class="col-md-12">
                <h2 class="section-title">Our Plans</h2>
               
            </div>

            <!-- Start of Pricing Tables -->
            <div class="pricing-tables">

				 <div class="col-md-2">
				 </div>
                <!-- Table 2 -->
                <div class="col-md-4" id="pro">
                    <div class="pricing-wrapper">
                        <!-- Start of Pricing Header -->
                        <div class="pricing-header">
                            <div class="price">
                                <span class="value">Single</span>
                            </div>

                            <div class="pricing-plan">
                                <img src="images/icons/pro.svg" alt="">
                               
                            </div>
                        </div>
                        <!-- End of Pricing Header -->

                        <!-- Start of Pricing Body -->
                        <div class="pricing-body">
                            <ul class="pricing-features">
                                <li><i class="fas fa-swimmer"></i> 4000 Per Month Without Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 5000 Per Month With Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 10000 For 3 Months Without Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 12000 For 3 Months With Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 18000 For 6 Months Without Coaching</li>
								<li><i class="fas fa-swimmer"></i> 22000 For 6 Months With Coaching</li>
                            </ul>
                        </div>
                        <!-- End of Pricing Body -->

                        <!-- Start of Pricing Footer -->
                        <div class="pricing-footer">
						<span class="attractive-text" style="color: #47c0eb;font-family: 'Open Sans', sans-serif;font-family: 'Pacifico', cursive;font-weight: bold;">Join us now and get an additional discount on the plans above!</span>
                        </div>
                        <!-- End of Pricing Footer -->
                    </div>
                </div>
                <!-- End Table 2 -->

                <!-- Table 3 -->
                <div class="col-md-4" id="ultra">
                    <div class="pricing-wrapper">
                        <!-- Start of Pricing Header -->
                        <div class="pricing-header">
                            <div class="price">
                                <span class="value">Family</span>
                            </div>

                            <div class="pricing-plan">
                                <img src="images/icons/basic.svg" alt="">
                                
                            </div>
                        </div>
                        <!-- End of Pricing Header -->

                        <!-- Start of Pricing Body -->
                        <div class="pricing-body">
                            <ul class="pricing-features">
                                <li><i class="fas fa-swimmer"></i> 10000 rs Per Month Without Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 12000 Per Month With Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 24000 For 3 Months Without Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 30000 For 3 Months With Coaching</li>
                                <li><i class="fas fa-swimmer"></i> 40000 For 6 Months Without Coaching</li>
								<li><i class="fas fa-swimmer"></i> 50000 For 6 Months With Coaching</li>
                            </ul>
                        </div>
                        <!-- End of Pricing Body -->

                        <!-- Start of Pricing Footer -->
                        <div class="pricing-footer">
						<span class="attractive-text" style="color: #47c0eb;font-family: 'Open Sans', sans-serif;font-family: 'Pacifico', cursive;font-weight: bold;">Join us now and get an additional discount on the plans above!</span>
                        </div>
                        <!-- End of Pricing Footer -->
                    </div>
                </div>
                <!-- End Table 3 -->
				<div class="col-md-2">
				 </div>
            </div>
            <!-- End of Pricing Tables -->

        </div>
    </section>
    <!-- ===== End of Blog Section ===== -->

    <!-- ===== Start of Sign Up Section ===== -->
    <section id="signup">
        <div class="container">
            <div class="col-md-6 col-md-offset-2">
                <h3 class="section-title">We value your feedback!  <strong>Share your experience</strong> and help us improve. <strong>Your input</strong> makes a difference!</h3>

            </div>

            <div class="col-md-4">
                <a href="javascript:void(0);"  data-toggle="modal" data-target="#feedback" class="btn">Give Feedback</a>
            </div>
        </div>
    </section>
    <!-- ===== End of Sign Up Section ===== -->



  <!-- ===== Start of Footer ===== -->
<footer id="main-footer">
    <div class="container">
        <!-- Start of Footer Top -->
        <div class="row footer-top">
            <!-- Start of Footer About -->
            <div class="col-md-6 col-xs-6 about">
                <img src="<?php echo LOGO_PATH;?>" alt="">
                <p>Make waves with us! Our academy transforms swimmers into champions, one stroke at a time. Dive into a world of fun, fitness, and growth. Your journey starts here!</p>
                <ul>
                    <li><span><i class="fa fa-map-marker"></i>Plot No. 6, Sitara Graden road, Behind Baba Mastnath University, Near V.N Memorial School, Sector 28, Rohtak</span></li>
                    <li><span><i class="fa fa-phone"></i>9996847777</span></li>
                    <li><span><i class="fa fa-phone"></i>9457857777</span></li>
                    <li><span><i class="fa fa-envelope-o"></i><a href="Javascript:void(0);" class="__cf_email__" >swimgymacademyrtk@gmail.com</a></span></li>
                </ul>
            </div>
            <!-- End of Footer About -->

            <!-- Start of Google Map Embed -->
            <div class="col-md-6 col-xs-12 footer-social">
                <h4>Find us here</h4>
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3493.933510666335!2d76.63919035366473!3d28.870595650120794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjjCsDUyJzE0LjAiTiA3NsKwMzgnMTYuNyJF!5e0!3m2!1sen!2sin!4v1716190761970!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <!-- End of Google Map Embed -->
        </div>
        <!-- End of Footer Top -->

        <!-- Footer Links -->
        <div class="row">
            <div class="col-md-12 text-center footer-links-container">
                <ul class="footer-links">
                    <li><a href="javascript:void(0);"><i class="fa-brands fa-square-facebook"></i></a></li>
                    <li><a href="javascript:void(0);"><i class="fa-brands fa-square-instagram"></i></a></li>
                </ul>
            </div>
        </div>
        <!-- End of Footer Links -->

        <!-- Start of Footer Copyright -->
        <div class="row">
            <div class="col-md-12 text-center copyright">
                <p>Copyright © Swim Gym Academy. All Rights Reserved.</p>
            </div>
        </div>
        <!-- End of Footer Copyright -->
    </div>
</footer>

    <!-- ===== End of Footer ===== -->
	<div id="contact_us" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Contact Us <button type="button" class="close" onclick="window.location.reload();" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></h5>
        
        </button>
      </div>
       <form method="POST" onsubmit="return false;" id="enquire_now">
			<div class="modal-body">
				<div class="col-xl-12 mb-3">
					<div class="mb-3">
						<label class="form-label">Name</label>
					 <input class="form-control input-box allowOnlyAlphabets" type="text" name="name" placeholder="Your Name" required>
					</div>
				</div>
				<div class="col-xl-12 mb-3">
					<div class="mb-3">
					<label class="form-label">Email</label>
					 <input class="form-control input-box validateEmail" type="email" name="email" placeholder="your@email.com" required>
					</div>
				</div>
				<div class="col-xl-12 mb-3">
					<div class="mb-3">
					<label class="form-label">Phone Number</label>
					 <input class="form-control input-box allowOnlyNumeric" type="tel" name="phone" placeholder="Phone Number" required>
					</div>
				</div>
				<div class="col-xl-12 mb-3">
					<div class="mb-3">
					<label class="form-label">Message</label>
					<textarea class="form-control textarea-box" rows="8" name="message" placeholder="Type your message..." required></textarea>
					</div>
				</div>
			</div>
			<input type='hidden' name='tab' value="<?php echo 'enquire_now'; ?>" />		
      <div class="modal-footer" style="text-align: center;">
        <button type="submit" class="btn btn-secondary" >Send</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<div id="feedback" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Your Feedback Matters!<button type="button" class="close" onclick="window.location.reload();" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></h5>
        
        </button>
      </div>
       <form method="POST" onsubmit="return false;" id="feedback_share">
			<div class="modal-body">
				<div class="col-xl-12 mb-3">
					<div class="mb-3">
						<label class="form-label">Name</label>
					 <input class="form-control input-box allowOnlyAlphabets" type="text" name="name" placeholder="Your Name" required>
					</div>
				</div>
				<div class="col-xl-12 mb-3">
					<div class="mb-3">
					<label class="form-label">Message</label>
					<textarea class="form-control textarea-box" rows="8" name="message" placeholder="Type your feedback..." required></textarea>
					</div>
				</div>
			</div>
			<input type='hidden' name='tab' value="<?php echo 'share_feedback'; ?>" />		
      <div class="modal-footer" style="text-align: center;">
        <button type="submit" class="btn btn-secondary" >Share</button>
      </div>
	  </form>
    </div>
  </div>
</div>


    <!-- ===== All Javascript at the bottom of the page for faster page loading ===== -->
    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/modernizr.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/swiper.min.js"></script>
    <script src="js/jquery.shuffle.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countTo.js"></script>
    <script src="js/jquery.inview.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/calendar.min.js"></script>
    <script src="js/jquery.ajaxchimp.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/custom-script.js"></script>
   <script src="<?php echo  APPLICATION_URL; ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>
</body>

</html>