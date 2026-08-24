<div id='body2'>
	<h1 class='bien'>Bulletin Annuel</h1>
		<form method='post' action='../traitement.php' target ='_blank'>
			Classe : <select name='classe' id='classe' onChange='goBullAnn()'>
				<option value='null'>-Classe-</option>
				<?php 
					$regions = $config->classesTraiteesAnn();
					for($i=0;$i<count($regions);$i++){
						echo "<option value='";
						echo $regions[$i]['classe'];
						echo "'>".strtoupper($regions[$i]['nom_classe'])."</option>";
					}
				?>
			</select>
			
			<div id='trimestre' style = 'display:inline'>
			</div>
			
		</form>
</div>