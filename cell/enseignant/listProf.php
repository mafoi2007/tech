<div id="body2">
   <h1 class='bien'>Liste des utilisateurs en exercice</h1>
   <table border='1' width='100%'>
        <tr>
            <th>N°</th>
            <th>Nom</th>
            <th>Login</th>
            <th>Poste</th>
        </tr>
        <?php $listeUtilisateur = $config->viewUserAll('actif');
        if(!empty($listeUtilisateur)){
            $a = 1;
            for($i=0;$i<count($listeUtilisateur);$i++){
                echo "<tr>
                    <td>".$a."</td>
                    <td>".stripslashes($listeUtilisateur[$i]['nom'])."</td>
                    <td>".$listeUtilisateur[$i]['login']."</td>
                    <td>".$listeUtilisateur[$i]['libelle_poste']."</td>
                </tr>";
                $a++;
            }
        }else{
            echo "<tr>
                <td colspan='5' align='center' class='alert'>Aucun Utilisateur Trouvé.</td>
            </tr>";
        } ?>
    </table>
</div>