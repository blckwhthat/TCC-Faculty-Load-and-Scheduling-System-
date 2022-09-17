
<style>
	.collapse a{
		text-indent:10px;
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
				<a href="index.php?page=schedule" class="nav-item nav-schedule"><span class='icon-field'><i class="fa fa-pen mr-2"></i></span> Schedule</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				
				
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
