<div id='body2'>
    <h1 class='bien'>Insérer plusieurs matières dans la classe</h1>
    <form method='post' action='../traitement.php'>
        Classe : 
            <select name='classe' id='classe' onChange='addSubjectClass()'>
                <?php 
                $classe = $config->viewClasseAll('actif');
                if(count($classe)==0){
                    echo "<option value='null'>-Aucune classe enregistrée-</option>";
                }else{
                    for($i=0;$i<count($classe);$i++){
						echo "<option value='";
						echo $classe[$i]['id'];
						echo "'>";
						echo ucwords($classe[$i]['nom_classe']);
						echo "</option>";
					}
					echo "<option value='null' selected>-Choisir la classe-</option>";
                }
                ?>
            </select>
            <div id='matiere'>
            </div>
</div>