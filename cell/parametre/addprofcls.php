<div id='body2'>
    <h1 class='bien'>Affecter un enseignant à une classe</h1>
    <form method='post' action='../traitement.php'>
        Classe : 
        <select name='classe' id='classe' onChange='addUserClass()'>
            <option value='null' selected>-Choix de la classe-</option>
			<?php 
			$listClass = $config->viewClasseAll('actif');
			if(!empty($listClass)){
				for($i=0;$i<count($listClass);$i++){
					echo "<option value='".$listClass[$i]['id']."'>".$listClass[$i]['nom_classe']."</option>";
				}
			}
			?>
		</select>
		<div id='matiere'>
		</div>
	</form>
</div>