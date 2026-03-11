<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $classe = (int) $_POST['classe'];
    if($classe==0){
        echo "<h3 class='alert'>Choisissez une classe</h3>";
    }else{
        $listeMatiere = $config->getMatiereClasse($classe);
        if(empty($listeMatiere)){
            echo "<h3 class='alert'>Cette Classe n'a encore aucune matière.</h3>";
        }else{
            //echo '<pre>'; print_r($listeMatiere); echo '</pre>'; ?>
            <table border='1' width='100%'>
                <tr>
                    <th>N°</th>
                    <th>Nom de la Matière</th>
					<th>Coef Actuel</th>
					<th>Groupe Actuel</th>
					<th>Nouveau Coef</th>
					<th>Nouveau Groupe</th>
                </tr>
            <?php 
            $a = 1;
            for($i=0;$i<count($listeMatiere);$i++){
                echo "<tr>";
                    echo "<td>".$a."<input type='hidden' name='refTable[]' value='".$listeMatiere[$i]['id']."' /></td>";
                    echo "<td>".$listeMatiere[$i]['nom_matiere']."</td>";
                    echo "<td>
                            <input 
                                type='text'
                                size='4' 
                                value='".$listeMatiere[$i]['coef']."' 
                                disabled /></td>";
                    echo "<td>
                            <input
                                type='text'
                                size='10'
                                value='".$listeMatiere[$i]['nom_groupe']."'
                                disabled /></td>";
                    echo "<td>
                            <input 
                                type='number' 
                                name='coef[]' 
                                id='coef[]' 
                                step ='0.1'
                                value='".$listeMatiere[$i]['coef']."'
                                min = '1'
                                max='10' /></td>";
                    echo "<td>";
                        echo "<select name='groupe[]'>";
                        $groupe = $config->listGroup();
                        for($x=0;$x<count($groupe);$x++){
                            echo "<option value='";
                            echo $groupe[$x]['id'];
                            echo "'";
                            if($listeMatiere[$i]['groupe']==$groupe[$x]['id']){
                                echo " selected";
                            }
                            echo ">".$groupe[$x]['nom_groupe']."</option>";
                        }
                        echo "</select>";
                    echo "</td>";
                echo "</tr>";
                $a++;
            } ?>
                <tr>
                    <td colspan='8' align='center'>
                        <input type='submit' name='updmatclss' value='Modifier les matières' />
                    </td>
                </tr>




<?php 
        }
    }