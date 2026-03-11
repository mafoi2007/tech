<?php 
	$user = $_SESSION['user']['userPost'];
	if($user=='cell'){
		require_once('menu_cell.php');
	}elseif($user=='admin'){
		require_once('menu_admin.php');
	}elseif($user=='prof'){
		require_once('menu_enseignant.php');
	}elseif($user=='chef'){
		require_once('menu_chef.php');
	}elseif($user=='sg'){
		require_once('menu_sg.php');
	}elseif($user=='eco'){
		require_once('menu_eco.php');
	}else{
		require_once('no_menu.php');
	}
?>
		
		
		
		
		
		
		
		
		
		
		