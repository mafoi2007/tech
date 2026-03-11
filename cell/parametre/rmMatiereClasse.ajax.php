<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $classe = (int) $_POST['classe'];
    if($classe==0){
        echo "<h3 class='alert'>Choisissez une classe</h3>";
    }else{
        $listeMatiere = $config->getMatiereClasse($classe);
        // echo '<pre>'; print_r($listeMatiere); echo '</pre>';
        if(empty($listeMatiere)){
            echo "<h3 class='alert'>Cette Classe n'a encore aucune matière.</h3>";
        }else{
            //echo '<pre>'; print_r($listeMatiere); echo '</pre>'; ?>
            <table border='1' width='70%'>
                <tr>
                    <th>N°</th>
                    <th>Nom de la Matière</th>
					<th>Cocher</th>
                </tr>
            <?php 
            $a = 1;
            for($i=0;$i<count($listeMatiere);$i++){
                echo "<tr>";
                    echo "<td>".$a."<input type='hidden' name='refTable[]' value='".$listeMatiere[$i]['id']."' /></td>";
                    echo "<td>".$listeMatiere[$i]['nom_matiere']."</td>";
                    echo "<td>";
                        echo "<input 
                            type='checkbox'
                            name='matiere[]'
                            value='".$listeMatiere[$i]['id']."'
                            />";
                    echo "</td>";
                echo "</tr>";
                $a++;
            } ?>
                <tr>
                    <td colspan='8' align='center'>
                        <input type='submit' name='rmmatclss' value='Supprimer les matières' />
                    </td>
                </tr>




<?php 
        }
    }