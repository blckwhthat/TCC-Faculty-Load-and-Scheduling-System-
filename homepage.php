<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('admin/db_connect.php');
ob_start();
ob_end_flush();
?>


<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>School Faculty Scheduling System</title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
		background: #FFCC00;

	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background: #E6BC10;
	}
	.new-color{
		background: #FFCC00;
	}
	#login-right{
		position: absolute;
		padding-top: 60px;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background: #FFCC00;
		display: flex;
		align-items: center;
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>);
	    background-repeat: no-repeat;
	    background-size: cover;
		justify-content: center;
	}
	#login-top{
		position: absolute;
		left:0;
		width:100%;
		height: 90px;
		background:#db3300;
		display: flex;
		align-items: center;
		background: url(img/LS_HeaderNav_img.png);
	    background-repeat: no-repeat;
	    background-size: cover;
		justify-content: center;
		z-index: 99;
	}
	#login-icon{
		top: 150px;
	
		width:60%;
		height: calc(100%);
		position: fixed;
		
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    background: #880d00;
}
/*slideshow*/
* {box-sizing: border-box;}
body {font-family: Verdana, sans-serif;}
.mySlides {display: none;}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 100%;
  position: relative;
  margin: auto;
}

/* The dots/bullets/indicators */
.dot {
  height: 15px;
  width: 15px;
  margin: 0 2px;
  background-color: #bbb;
  border-radius: 50%;
  display: inline-block;
  transition: background-color 0.6s ease;
}

.active {
  background-color: #717171;
}

/* Fading animation */
.fade {
  -webkit-animation-name: fade;
  -webkit-animation-duration: 1.5s;
  animation-name: fade;
  animation-duration: 1.5s;
}

@-webkit-keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

@keyframes fade {
  from {opacity: .4} 
  to {opacity: 1}
}

/* On smaller screens, decrease text size */
@media only screen and (max-width: 300px) {
  .text {font-size: 11px}
}
/*slideshow end*/

</style>

<body>


  <main id="main" class="new-color">
  		<div id="login-left" class="new-color"></div>
		  <div id="login-icon" class="new-color">
			  
			  <div class="slideshow-container">

				<div class="mySlides fade">
				<center><img src="img/IMG_LoginSide.png" ></center>
				</div>

				<div class="mySlides fade">
				<center><img src="img/IMG_LoginSide.png" ></center>
				</div>

				<div class="mySlides fade">
				<center><img src="img/IMG_LoginSide.png" ></center>
				</div>
				</div>
				<br>

				<div style="text-align:center">
				<span class="dot"></span> 
				<span class="dot"></span> 
				<span class="dot"></span> 
				</div>
  		 </div>
		<div id="login-top" class="red"></div>

  		<div id="login-right" class="new-color">
  			<div class="card col-md-8 new-color shadow">
  				<div class="card-body">
  						
  					<form id="login-form" >
					  <center><label for="" class="control-label text-dark text-login ">Please choose an option:</label></center>
  						<div class="form-group">
						  	
  							<label for="" class="control-label text-dark">Login as administrator</label>
							<center><a href="admin/login.php"><button type="button" class="btn btn-primary btn-block col-md-12 text-white shadow">Administrator</button></a></center>
  						</div>
  						<div class="form-group">
						<label for="" class="control-label text-dark">Login as faculty</label>
						<center><a href="login.php"><button type="button" class="btn btn-primary btn-block col-md-12 text-white shadow">Faculty</button></a></center>
  						</div>
  					</form>
  				</div>
  			</div>
  		</div>
   

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
var slideIndex = 0;
showSlides();

function showSlides() {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}    
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
  setTimeout(showSlides, 2000); // Change image every 2 seconds
}
</script>


</html>