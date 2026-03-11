<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
  if(isset($_POST['prof'])){
    $prof = $_POST['prof']; ?>
    <h1 class='alert'>Resultats de la Recherche</h1>
    <table border='1' width='100%'>
        <tr>
            <th>N°</th>
            <th>Nom de l'enseignant</th>
            <th>Détails</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
<?php 
        $listeProf = $config->findProf($prof);
        $page = "enseignant.php?action=";
        if(empty($listeProf)){
            echo "<tr>
                    <th colspan='9' class='alert'>Aucun enseignant correspondant.</th>
                </tr>";
        }else{
            $a = 1;
            for($i=0;$i<count($listeProf); $i++){ ?>
        <tr>
            <td><?php echo $a; ?></td>
            <td><?php echo $listeProf[$i]['nom']; ?></td>
            <td><a href="enseignant.php?action=detail&amp;id=<?php echo $listeProf[$i]['id']; ?>#body2">Détails</a></td>
            
            <td><a href="enseignant.php?action=update&amp;id=<?php echo $listeProf[$i]['id']; ?>#body2">Modifier</a></td>
            <?php 
            if($listeProf[$i]['etat']=='actif'){ ?>
            <td><a href="enseignant.php?action=delete&amp;id=<?php echo $listeProf[$i]['id']; ?>#body2">Supprimer</a></td>
    <?php
            }
            elseif($listeProf[$i]['etat']=='inactif'){ ?>
            <td><a href="enseignant.php?action=restaure&amp;id=<?php echo $listeProf[$i]['id']; ?>#body2">Restaurer</a></td>
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