<?php
if(isset($_GET['id'])){
    $rubrique = $finance->getRubrique($_GET['id']);
     ?>
    <div id='body2'>
        <h1 class='alert'>Modifier une rubrique</h1>
        <form method='post' action='../traitement.php' target=_blank>
            <table border='0' width='70%' align='center'>
                <tr>
                    <th>Libellé</th>
                    <th>Ancienne Valeur</th>
                    <th>Nouvelle Valeur</th>
                </tr>
                <tr>
                    <th>Nom de la Rubrique</th>
                    <th>
                        <input 
                            type='text'
                            disabled
                            value="<?php echo str_replace('_',' ',stripslashes($rubrique['nom_rubrique'])); ?>"
                        />
                    </th>
                    <th>
                        <input 
                            type='text'
                            name='nomRubrique'
                            value="<?php echo str_replace('_',' ',stripslashes($rubrique['nom_rubrique'])); ?>"
                        />
                    </th>
                </tr>
                <tr>
                    <th>Code de la Rubrique</th>
                    <th>
                        <input 
                            type='text'
                            disabled
                            value="<?php echo str_replace('_',' ',stripslashes($rubrique['code_rubrique'])); ?>"
                        />
                    </th>
                    <th>
                        <input 
                            type='text'
                            name='codeRubrique'
                            value="<?php echo str_replace('_',' ',stripslashes($rubrique['code_rubrique'])); ?>"
                        />
                    </th>
                <input 
                    type='hidden'
                    name='idRubrique'
                    value="<?php echo $rubrique['id']; ?>"
                />
                <tr>
                    <td colspan='2' align='center'>
                        <input 
                            type='submit'
                            name='finance'
                            value='Modifier'
                        />
                        <input 
                            type='hidden'
                            name='nature'
                            value='editRubrique'
                        />
                    </td>
                    <td>
                        <input 
                            type='reset' 
                            name='editRubrique' 
                            value='Annuler' 
                        />
                    </td>
                </tr>
            </table>
        </form>
    </div>

<?php 
}else{
    $_SESSION['message'] = 'Aucune rubrique choisie.';
    header('Location:'.$_SERVER['PHP_SELF']);
}