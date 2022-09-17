
<style>
	.collapse a{
		text-indent:10px;
	}
	
	.dropdown-menu{
		float: right;
		background-color: #A80d00;
		width: 245px; 
		top: 0;
	}
	.dropdown-item{
		padding-top: 15px;
		align-items: center;
		height: 50px;
		color: #fff;
	}
	.dropdown-menu:hover{
		background-color: #A80d00;
		color: #fff;
	}
	.dropdown-item:hover{
		background-color: #FFCC00;
		color: #000;
	}
</style>

<div id="side" class="shadow">
<nav id="sidebar" class='mx-lt-5 shadow-lg'>
		<div id="s-list" class="sidebar-list ">
				<div id="navbar_toggle">
				<a href="#" class="nav-button text-dark"><i class="fas fa-bars fa-lg text-dark button-one" id="for-calendar" onclick="hideButton()"></i> LoadSched</a>
           		</a>
         		</div>
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home mr-2" style="font-weight: 800;"></i></span> Home</a>
				<a href="index.php?page=courses" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-list mr-2"style="font-weight: 800;"></i></span> Program </a>
				<a href="index.php?page=subjects" class="nav-item nav-subjects"><span class='icon-field'><i class="fa fa-shapes mr-2" style="font-weight: 800;"></i></span> Course </a>
				<a href="index.php?page=faculty" class="nav-item nav-faculty"><span class='icon-field'><i class="fa fa-users mr-2" style="font-weight: 800;"></i></span> Faculty </a>
				<a href="index.php?page=classroom" class="nav-item nav-classroom"><span class='icon-field'><i class="fa fa-chalkboard-teacher mr-2"></i></span> Rooms</a>
				<a href="index.php?page=schedule" class="nav-item nav-schedule"><span class='icon-field'><i class="fa fa-pen mr-2"></i></span> Schedule</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-user-plus mr-2"></i></span> Users</a>
				<div class="dropright">
				<a href="#" class="nav-item nav-modal_print dropdown-toggle-split prints" data-toggle="dropdown"><span class='icon-field'><i class="fa fa-print mr-2"></i></span> Print</a>
				<div class="dropdown-menu ">
					<center><a href="print.php" class="dropdown-item "> Faculty</a></center>
					<center><a href="print_phead.php" class="dropdown-item "> Program Head</a></center>
				</div>
				
				
			<?php endif; ?>
		</div>
</nav>
</div>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
<script src="condition.js"></script>
<script src="https://kit.fontawesome.com/33ef24c364.js" crossorigin="anonymous"></script>
