<h1 class='alert'>Faire le conseil de classe</h1>
<form method='post' action='../traitement.php'>
	<?php 
        $listeClasse = $config->classesTraiteesAnn();
        if($listeClasse==NULL){
            $msg = "<h3 class='alert'>Aucune classe prête pour le conseil.</h3>";
        }else{
            // echo '<pre>'; print_r($listeClasse); echo '</pre>'; ?>
            Classe : 
                <select name='classe' id='classe' onChange='showConseil()'>
                    <?php 
                    for($i=0;$i<count($listeClasse);$i++){
                        if($listeClasse[$i]['conseil']=='non'){
                            echo "<option value='".$listeClasse[$i]['classe']."'>".$listeClasse[$i]['nom_classe']."</option>";
                        }
                    }?>
                    <option value='null' selected>-Choisir une classe-</option>
                </select>
    <?php 
        }
		 ?>			
			<div id='eleve'></div>
</form>