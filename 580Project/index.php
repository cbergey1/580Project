<?php
include 'core/init.php';
?>
<html>
	<?php
	include 'phpinclude/head.php';
	?>
	<title>Title Goes Here</title>
	</head>

	<body>
		<?php
		if(Users::isLoggedIn()){
			include 'phpinclude/navbarloggedin.php';
		}else{
			include 'phpinclude/navbar.php';
		}
		include 'modalpages/login.php';
		include 'modalpages/contact.html';
		include 'modalpages/about.html';
		?>
		<!--Start br tags to get content below navbar-->
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<!--End br tags-->

		<!-- Start Page Content -->
		<div id="indexhomediv">
    		<div class="container">
    			<div class="row">
    				<div class = "col-sm-4"></div>
    				<div class = "col-sm-4">
    					<center><p>Content Here</p></center>
    				</div>
    				<div class = "col-sm-4"></div>
    			</div>
    		</div>
    	</div>


	</body>
	
</html>