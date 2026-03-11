<div id='body2'>
    <h1 class='bien'>Listing des Séquences Activées</h1>
    <form method='post' action='../traitement.php'>
        <table border='1' width='50%'>
            <tr>
                <td>N°</td>
                <td> Nom de la Séquence </td>
                <td> Date d'ouverture </td>
                <td> Date de cloture </td>
            </tr>
            <tr>
                <?php 
                $listePeriode = $config->periodeCourante();
                if(!empty($listePeriode)){
                    $a = 1;
                    for($i=0;$i<count($listePeriode);$i++){
                        echo "<tr>
                            <td align='center'>".$a."</td>
                            <td>".$listePeriode[$i]['nom_periode']."</td>
                            <td>".$listePeriode[$i]['ouvert']."</td>
                            <td>".$listePeriode[$i]['fermet']."</td>
                        </tr>";
                        $a++;
                    }
                }else{
                    echo "<tr><td colspan='5'>Aucune séquence activée.</td></tr>";
                }
                ?>
                
            </tr>
        </table>
    </form>
</div>