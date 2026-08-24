<?php 
$classe = $config->classesTraiteesAnn();
// echo '<pre>'; print_r($classe); echo '</pre>';
?>
<div id='body2'>
	<h1 class='bien'>traitement des moyennes annuelles</h1>
		<form method='post' action='../traitement.php'>
			Classe : <select name='classe' id='classe' onChange='goTraitMoyAnn()'>
				<option value='null'>-Classe-</option>
				<?php 
					for($i=0;$i<count($classe);$i++){
						echo "<option value='";
						echo $classe[$i]['classe'];
						echo "'>".strtoupper($classe[$i]['nom_classe'])."</option>";
					}
				?>
			</select>
			
			<div id='trimestre' style = 'display:inline'>
			</div>
		</form>
</div>