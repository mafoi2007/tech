<?php 
if(isset($_GET['id'])){
    $rubrique = $finance->getRubrique($_GET['id']); ?>
    <div id='body2'>
        <h1 class='alert'>Restaurer une rubrique</h1>
        <form method='post' action='../traitement.php' target='_blank'>
            <h3>Voulez-vous vraiment RESTAURER la Rubrique
                <font color='red'>
                    <?php echo str_replace('_',' ',stripslashes($rubrique['nom_rubrique']));?>
                </font>
                ? <input 
                    type='submit' 
                    name='finance' 
                    value='Oui' />
                &nbsp;  &nbsp;
                <input 
                    type='submit' 
                    name='finance' 
                    value='Non' />
            </h3>
            <input 
                type='hidden' 
                name='idRubrique' 
                value='<?php echo $_GET['id'];?>' />
            <input 
                type='hidden'
                name = 'nature'
                value='updateRubrique' />
        </form>
    </div>

<?php     
}else{
    $_SESSION['message'] = 'Aucune rubrique choisie.';
    header('Location:'.$_SERVER['PHP_SELF']);
}