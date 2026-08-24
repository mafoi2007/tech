<?php 
$listeClasse = $config->verifAnnuel(); 
// echo '<pre>'; print_r($listeClasse); echo '</pre>';
?>
<div id='body2'>
	<h1 class='bien'>traitement des notes Annuelles</h1>
	<form method='post' action='../traitement.php' target ='_blank'>
		Classe : <select name='classe' id='classe' onChange='goTraitNtAnn()'>
			<option value='null'>-Classe-</option>
			<?php 
				for($i=0;$i<count($listeClasse);$i++){
					echo "<option value='";
					echo $listeClasse[$i]['classe'];
					echo "'>".strtoupper($listeClasse[$i]['nom_classe'])."</option>";
				}
			?>
		</select>
		
		<div id='trimestre' style = 'display:inline'>
		</div>
	</form>
</div>
