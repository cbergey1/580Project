<?php
	function sanitize($conn, $data){
		return mysqli_real_escape_string($conn, $data);
	}
?>