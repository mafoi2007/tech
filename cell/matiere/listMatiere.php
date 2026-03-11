<div id='body2'>
    <h1 class='alert'>Liste des Matières</h1>
    <table border='1' width='75%'>
        <tr>
            <th>N°</th>
            <th>Nom de la Matière</th>
            <th>Code de la Matière</th>
        </tr>
    <?php 
    $listeMatiere = $config->getMatiereAll('actif');
    if(empty($listeMatiere)){
        echo "<tr>
            <td colspan='3' align='center' class='bien'>Aucune Matière Enregistrée.</td>
        </tr>";
    }else{
        $a = 1;
        for($i=0;$i<count($listeMatiere);$i++){ ?>
        <tr>
            <td align='center'><?php echo $a; ?></td>
            <td><?php echo $listeMatiere[$i]['nom_matiere']; ?></td>
            <td><?php echo $listeMatiere[$i]['code_matiere']; ?></td>
        </tr>
<?php         
        $a++;
        }
    }
?>
    </table>
</div>