<div id="body2">
   <h1 class='bien'>Liste des classes actives</h1>
   <table border='1' width='100%'>
        <tr>
            <th>N°</th>
            <th>Nom</th>
            <th>Code</th>
            <th>Niveau</th>
            <th>Section</th>
        </tr>
        <?php $listeClasse = $config->viewClasseAll('actif');
        if(!empty($listeClasse)){
            $a = 1;
            for($i=0;$i<count($listeClasse);$i++){
                echo "<tr>
                    <td>".$a."</td>
                    <td>".$listeClasse[$i]['nom_classe']."</td>
                    <td>".$listeClasse[$i]['code_classe']."</td>
                    <td>".$listeClasse[$i]['nom_niveau']."</td>
                    <td>".$config->transformSection($listeClasse[$i]['section'])."</td>
                </tr>";
                $a++;
            }
        }else{
            echo "<tr>
                <td colspan='5' align='center' class='alert'>Aucune Classe Trouvée.</td>
            </tr>";
        } ?>
    </table>
</div>