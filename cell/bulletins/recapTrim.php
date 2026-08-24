<div id='body2'>
    <h1 class='bien'>récapitulatif trimestriel</h1>
	<?php 
	$listeTrim = $config->trimestresTraitesAll();
	// echo '<pre>'; print_r($listeTrim);echo '</pre>';
	?>
	<form method='post' action='../traitement.php' target='_blank'>
		Choisir le trimestre : 
			<select name='trimestre' id='trimestre' OnChange = 'goStat()'>
                <option value='null' selected>-Choisir-</option>
				<?php 
				for($x=0;$x<count($listeTrim);$x++){
					echo "<option value='".$listeTrim[$x]."'>Trimestre ".$listeTrim[$x]."</option>";
				} ?>
            </select>
            <div id='periode' style='display:inline'>
            </div>
	</form>
</div>