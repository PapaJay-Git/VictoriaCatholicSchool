<?php
require_once $_SERVER['DOCUMENT_ROOT']."/Backend-routes/admin/includes_get_events_home.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Victoria Catholic School</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">

  <!-- FONT -->
	<link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">
    
  <!-- Animate CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="../../css/style_home.css">
	
	<link rel="icon" href="../../images/victoria.ico">
	<link rel="stylesheet" href="../../css/assets/dataTables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../../css/assets/dataTables/buttons.dataTables.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
	

  <link rel="stylesheet" href="../../owlcarousel/owl.carousel.min.css">
  <link rel="stylesheet" href="../../owlcarousel/owl.theme.default.min.css">
</head>

<body class="body-home">

<!-- HEADER -->
<header role="banner">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top border-bottom border-warning border-3 animate__animated animate__fadeIn">
    <div class="container">
      <a class="navbar-brand fs-6" href="#"><img class ="logo" src="../../images/victoria.png" width="45px" height="45px"> Victoria Catholic School</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon fs-6"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav ms-auto ">
          <li class="nav-item">
            <a class="navs nav-link mx-2" aria-current="page" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="#admission">Admission</a>
          </li>
          <li class="nav-item">
            <a class="navs nav-link mx-2" href="#contact">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mx-2 btn-warning" href="login.php">LOGIN</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<!-- END header -->

<!-- HOME -->
<section id="home">
  <div class="hero text-center bg-image"style="background-image: url('../../images/cover.jpg'),linear-gradient(rgba(0,0,0,0.8),rgba(0,0,0,0.8));">
    <div class="d-flex justify-content-center align-items-center h-100">
      <div class="container">
        <div class="text-start">
          <h3 class="text-warning fw-bold animate__animated animate__fadeInLeft">WELCOME TO</h3>
          <h1 class="display-5 fw-bold text-white animate__animated animate__fadeInLeft">VICTORIA CATHOLIC SCHOOL OF<br> TARLAC INC.</h1>
          <h2 class="text-white fw-bold animate__animated animate__fadeInLeft">Junior Highschool</h2>
          <p class="text-white fs-5 text mb-5 footer-copyright animate__animated animate__fadeInLeft">Be Part of VCS Family. Choose VCS. Choose the BEST!</p>
          <a class="btn btn-warning animate__animated animate__fadeInUp" href="regis.php">Enroll now</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- HOME-->




<!-- Why choose VCS -->
<div class="bg-warning py-5">
  <div class="container">
    <h3 class="display-6 text-white fw-bold text-center pb-5"><span style="border-bottom: 3px solid #000; padding-bottom: 10px;">WHY CHOOSE VCS?</span></h3>
    
    <div class="row">
      
      <div class="col-lg-4 mb-3">
        <div class="card bg-white p-4 card-hover">
          <i class="fa-solid fa-masks-theater fa-3x text-center" style="color: #000000;"></i>
          <div class="card-body">
            <p class="card-text text-black text-center">It's more fun in VCS.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="card bg-white p-4 card-hover">
          <i class="fa-solid fa-user-graduate fa-3x text-center" style="color: #000000;"></i>
          <div class="card-body">
            <p class="card-text text-black text-center">High Standard Education.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="card bg-white p-4 card-hover">
          <i class="fa-solid fa-person-chalkboard fa-3x text-center" style="color: #000000;"></i>
          <div class="card-body">
            <p class="card-text text-black text-center">Teacher are your second parent.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="card bg-white p-4 card-hover">
          <i class="fa-solid fa-cross fa-3x text-center" style="color: #000000;"></i>
          <div class="card-body">
            <p class="card-text text-black text-center">Christian Formation.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="card bg-white p-4 card-hover">
          <i class="fa-solid fa-hand-holding-heart fa-3x text-center" style="color: #000000;"></i>
          <div class="card-body">
            <p class="card-text text-black text-center">VCSians are holistically developed.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-3">
        <div class="card bg-white p-4 card-hover">
          <i class="fa-solid fa-users fa-3x text-center" style="color: #000000;"></i>
          <div class="card-body">
            <p class="card-text text-black text-center">Friendly Environment.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- Why choose VCS -->

<!-- About -->
<section id="about">
  <div class="bg-black">
    <div class="container py-4">
      <div class="row">
      
      <!-- VCS -->
      <div class="p-5 mb-4 bg-black">
          <h3 class="display-6 text-white fw-bold pb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">ABOUT THE VCS</span></h3>
          <p class="col-md-8 fs-4 text-white"><b>VICTORIA CATHOLIC SCHOOL</b> is a filipino Catholic educational institution animated by the Spirit of the Gospel and inspired by the life of the Blessed Virgin Mary and St. Dominic.</p>
      </div>
      <!-- VCS -->

      <div class="row mx-auto">
        <!-- Vision -->
        <div class="col-lg-6 mb-3">
          <div class="h-100 p-5 bg-white border">
            <h2 class="text-black fw-bold "><span style="border-bottom: 3px solid #ffd308; padding-bottom: 5px;">VISION</span></h2>
            <p class="text-black pt-1"><b>VICTORIA CATHOLIC SCHOOL</b> is dedicated to the formation of the whole dimension of every individual, upholds Gospel Values, Christian Leadership, Academic Excellence In the service of God and of His Church.</p>
          </div>
        </div>
        <!-- Vision -->

        <!-- Mission -->
        <div class="col-lg-6 mb-3">
          <div class="h-100 p-5 bg-white border">
            <h2 class="text-black fw-bold "><span style="border-bottom: 3px solid #ffd308; padding-bottom: 5px;">MISSION</span></h2>
            <p class="text-black pt-1">We, the Christian Catholic of <b>VICTORIA CATHOLIC SCHOOL</b> commit ourselves to promote individual success and welfare through the harmonious development of the various aspects of human personality to teach the best ideals, to develop socially responsible individuals, to maintain and perpetuate intellectual growth, and to strengthen the spiritual life of the community.</p>
          </div>
        </div>
        <!-- Mission -->

      </div>      
    </div>
  </div>
</section>
<!-- About -->

<!-- Events -->
<section id="about">
  <div class="bg-">
    <div class="container py-4">
      <div class="row">
      
      <div class="col-lg-12 px-5 py-3">
          <h3 class="display-6 text-dark fw-bold pb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">EVENTS</span></h3>
      </div>

      <?php foreach($events as $event){ ?>

                <div class="col-lg-12 mb-3">
                  <div class="h-100 p-5 bg-white border shadow shadow-lg">
                    <h2 class="text-black fw-bold "><span style="border-bottom: 3px solid #ffd308; padding-bottom: 5px;"><?php echo $event['title'] ?></span></h2>
                    <p class="pt-3"><?php echo $event['description']; ?></p>
                  </div>
                </div>

      <?php }
      
      if($events->num_rows == 0){
          ?>

          <div class="col-lg-12 mb-3">
            <div class="h-100 p-5 bg-white border">
              <h2 class="text-black fw-bold "><span style="border-bottom: 3px solid #ffd308; padding-bottom: 5px;">No Events Available</span></h2>
              <p class="pt-3">STAY TUNED</p>
            </div>
          </div>
        <?php
      }
      ?>    
    </div>
  </div>
</section>
<!-- Events -->


<!-- Admission -->
<section id="admission">
  <div class="bg-dark">
    <div class="container py-4">
      <div class="row">
      
      <!-- Header -->
      <div class="p-5 mb-4 ">
        <h3 class="display-6 text-white fw-bold pb-4"><span style="border-bottom: 3px solid #ffd308; padding-bottom: 10px;">ADMISSON REQUIREMENTS</span></h3>

        <ul class="list-group">
          <li class="list-group-item disabled bg-dark border-0 fs-4 fw-bold text-white py-3" aria-disabled="true">Old Student</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white mb-3"><i class="fa-solid fa-circle-check"></i> For Old Students, there are no requirements to be submitted and directly proceed for payment in the cashier’s office.</li>
        </ul>

        <ul class="list-group">
          <li class="list-group-item disabled bg-dark border-0 fs-4 fw-bold text-white py-3" aria-disabled="true">New Student</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Original Form 138-A</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Certificate of Good Moral</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Photocopy of Baptismal and Birth Certificate (NSO Certifies)</li>
        </ul>

        <ul class="list-group">
          <li class="list-group-item disabled bg-dark border-0 fs-4 fw-bold text-white py-3" aria-disabled="true">Transferees</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Original Form 138-A</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Certificate of Good Moral</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Photocopy of Baptismal and Birth Certificate (NSO Certifies)</li>
          <li class="list-group-item bg-dark border-0 ml-3 text-white"><i class="fa-solid fa-circle-check"></i> Honorary Dismissal</li>
        </ul>

      </div>
      <!-- Header -->

      </div>      
    </div>
  </div>
</section>
<!-- Admission -->



<!-- Contact -->
<section id="contact">
  <div class="bg-white text-black">
    <div class="container py-5">
      <div class="row">

          <!-- Map -->
          <div class="col-lg-6 py-3">
            <div class="gmap_canvas">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3843.263770823104!2d120.67788391064519!3d15.577549752350546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396c646aa780f4d%3A0x7187b964c0996c3d!2sVictoria%20Catholic%20School!5e0!3m2!1sen!2sph!4v1700576702165!5m2!1sen!2sph" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>
          <!-- Map -->
        

          <!-- Contact phone, email and socials -->
          <div class="col-lg-6 pt-4 my-auto">
            <p><i class="fas fa-map-marker-alt"></i> Victoria Catholic School of Tarlac Inc., Sta. Lucia, Victoria, Tarlac, Philippines</p>
            <p><i class="fa fa-envelope "></i><a class="link-dark link-underline-opacity-0" href="victoriakatoliko.edu.ph@gmail.com" target="_blank"> victoriakatoliko.edu.ph@gmail.com</a></p>
            <i class="fa fa-phone"></i>
              <label style="margin-left: 15px;">Cellular:</label> 
              <ul style="list-style: none;">
                <li>+63956-165-5987</li>
                <li>+63919-296-3661</li>
              </ul>
              <a class="link-dark link-underline-opacity-0" href="https://www.facebook.com/VictoriaCatholicSchool/" target="_blank"><i class="fab fa-facebook-f fa-lg link-underline-opacity-0"></i><span> VictoriaCatholicSchool</span></a>            
          </div>
          <!-- Contact phone, email and socials -->


          
        </div>

      </div>    
    </div>
  </div>
</section>
<!-- Contact -->

<!-- Footer -->
<footer class="footer text-lg-start text-white border-top border-warning border-3">
<div class="container">
			<div class="row">
				<div class="col-md-12 py-3">
					<div class="text-center py-4"><a href="#"><img src="../../images/victoria.png" width="100px" height="100px" alt="logo"></a></div>					
					<div class="footer-copyright">
						<p class="text-center pb-3">
							<span class="white-text">Copyright © 2023 - Victoria Catholic School of Tarlac. All Rights Reserved.</span><br>
							<small class="text-muted">Sta. Lucia, Victoria, Tarlac, Philippines</small><br>
						</p>
						
					</div>					
				</div>
			</div>			
		</div>		
</footer>
<!-- Footer -->

</body>



<?php
	require_once "../includes/includes_scripts.php";
?>
<script src="../../owlcarousel/owl.carousel.min.js"></script>

<script>
  $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
</script>