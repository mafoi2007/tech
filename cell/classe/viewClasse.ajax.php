<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
  if(isset($_POST['clas'])){
    $classe = $_POST['clas']; ?>
    <h1 class='alert'>Resultats de la Recherche</h1>
    <table border='1' width='100%'>
        <tr>
            <th>N°</th>
            <th>Nom de la Classe</th>
            <th>Code</th>
            <th>Section</th>
            <th>Détails</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
<?php 
        $listeClasse = $config->findClasse($classe);
        // echo '<pre>'; print_r($listeClasse); echo '</pre>';
        $page = "classe.php?action=";
        if(empty($listeClasse)){
            echo "<tr>
                    <th colspan='9' class='alert'>Aucune classe correspondante.</th>
                </tr>";
        }else{
            $a = 1;
            for($i=0;$i<count($listeClasse); $i++){ ?>
        <tr>
            <td><?php echo $a; ?></td>
            <td><?php echo $listeClasse[$i]['nom_classe']; ?></td>
            <td><?php echo $listeClasse[$i]['code_classe']; ?></td>
            <td><?php echo $listeClasse[$i]['section']; ?></td>
            <td><a href="classe.php?action=detail&amp;id=<?php echo $listeClasse[$i]['id']; ?>#body2">Détails</a></td>
            <td><a href="classe.php?action=update&amp;id=<?php echo $listeClasse[$i]['id']; ?>#body2">Modifier</a></td>
            <?php 
            if($listeClasse[$i]['etat_classe']=='actif'){ ?>
            <td><a href="classe.php?action=delete&amp;id=<?php echo $listeClasse[$i]['id']; ?>#body2">Supprimer</a></td>
    <?php
            }
            elseif($listeClasse[$i]['etat_classe']=='inactif'){ ?>
            <td><a href="classe.php?action=restaure&amp;id=<?php echo $listeClasse[$i]['id']; ?>#body2">Restaurer</a></td>
            <?php }
            ?>
            
            
        </tr>
<?php 
            $a++;
            }
        }
  }
?>
	</table>	