<div id='body2'>
    <h1 class='bien'>Activation de séquence</h1>
    <form method='post' action='../traitement.php'>
        <table border='0' width='50%'>
            <tr>
                <td>Séquence à activer</td>
                <td> &nbsp; </td>
                <td>
                    <select name='sequence' id='sequence'>
                        <option value='null'>-Choisir Séquence-</option>
                        <?php 
                        $listePeriode = $config->listePeriodeAll();
                        for($i=0;$i<count($listePeriode);$i++){
                            echo "<option value='";
                            echo $listePeriode[$i]['id']."'>".$listePeriode[$i]['nom_periode']."</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
               <td> &nbsp; </td>
               <td> &nbsp; </td>
               <td> &nbsp; </td>
            </tr>
            <tr>
                <td>Nombre de jours d'activation :</td>
                <td> &nbsp; </td>
                <td><input type='number' name='nbjour' min='1' max='7' required /></td>
            </tr>
            <tr>
                <td colspan='3' align='center'>
                    <input type='submit' name='openSeq' value='Activer la Séquence' />
                </td>
            </tr>
        </table>
    </form>
</div>