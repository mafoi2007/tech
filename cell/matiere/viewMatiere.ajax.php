<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new Config($db);
  if(isset($_POST['matiere'])){
    $matiere = $_POST['matiere']; ?>
    <h1 class='alert'>Resultats de la Recherche</h1>
    <table border='1' width='100%'>
        <tr>
            <th>N°</th>
            <th>Nom de la Matière</th>
            <th>Code de la Matière</th>
            <th>Option</th>
        </tr>
<?php 
        $listeMatiere = $config->findMatiere($matiere);
        // echo '<pre>'; print_r($listeMatiere); echo '</pre>';
        $page = "matiere.php?action=editMatiere&amp;id=";
        if(empty($listeMatiere)){
            echo "<tr>
                    <th colspan='9' class='alert'>Aucune matière correspondante.</th>
                </tr>";
        }else{
            $a = 1;
            for($i=0;$i<count($listeMatiere); $i++){ ?>
        <tr>
            <td><?php echo $a; ?></td>
            <td><?php echo $listeMatiere[$i]['nom_matiere']; ?></td>
            <td><?php echo $listeMatiere[$i]['code_matiere']; ?></td>
            <td><a href="<?php echo $page.$listeMatiere[$i]['id']; ?>#body2">Editer</a></td>
        </tr>
<?php 
            $a++;
            }
        }
  }
?>
	</table>	