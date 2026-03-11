<div id='body2'>
    <h1 class='bien'>Verouillage de séquence</h1>
    <form method='post' action='../traitement.php'>
        <table border='0' width='50%'>
            <tr>
                <td>Séquence à verouiller</td>
                <td> &nbsp; </td>
                <td>
                    <select name='sequence' id='sequence'>
                        <option value='null'>-Choisir Séquence-</option>
                        <?php 
                        $listePeriode = $config->periodeCourante();
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
                <td colspan='3' align='center'>
                    <input type='submit' name='closeSeq' value='Verouiller la Séquence' />
                </td>
            </tr>
        </table>
    </form>
</div>