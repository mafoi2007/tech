<div id='body2'>
    <?php $eleve = $config->listeEleveAbsence(); /*echo '<pre>'; print_r($eleve); echo '</pre>';*/ ?>
    <h1 class='alert'>consultation des absences</h1>
    <form method='post' action='../traitement.php'>
		Eleve : <select name='eleve' id='eleve' onChange='goView()'>
			<option value='null'>-Eleve-</option>
			<?php 
				for($i=0;$i<count($eleve);$i++){
					echo "<option value='";
					echo $eleve[$i]['id_eleve'];
					echo "'>".strtoupper($eleve[$i]['nom_complet'])."</option>";
				}
			?>
		</select>
		
		<div id='view'>
		</div>
		
	</form>
   
</div>




