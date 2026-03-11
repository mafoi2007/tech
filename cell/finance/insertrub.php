<div id='body2'>
    <h1 class='alert'>Ajouter une rubrique à la classe</h1>
    <form method='post' action='../traitement.php' target='_blank'>
        Classe : 
            <select name='classe' id='classe' onChange='addRubClasse()'>
                <option value='null' selected>-Classe-</option>
                <?php 
                $listeClasse = $config->viewClasseAll('actif');
                for($i=0;$i<count($listeClasse);$i++){
                    echo "<option value='";
                    echo $listeClasse[$i]['id'];
                    echo "'>".$listeClasse[$i]['nom_classe']."</option>";
                }
                ?>
            </select>
        <div id='rubrique' style='display:inline'>
        </div>
    </form>
</div>