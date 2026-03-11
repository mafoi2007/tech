<div id='body2'>
    <h1 class='alert'>supprimer une classe</h1>
    <?php 
    if(isset($_GET['id'])){
        $classe = (int) urldecode($_GET['id']);
        $detailClasse = $config->getClasse($classe);
        if(empty($detailClasse)){
            echo "<h3 class='alert'>La Classe sollicitée n'existe pas.</h3>";
        }else{ 
            ?>
        <form method='post' action='../traitement.php'>
            <h4>Vous avez choisi de supprimer la classe <?php echo $detailClasse['nom_classe']; ?>.
            En êtes -vous sûr ? 
            <input 
                type='hidden' 
                name='classe' 
                value='<?php echo $detailClasse['id']; ?>' />
            <input 
                type='submit' 
                name='delClasse' 
                id='delClasse'
                value='oui' />  
            <input 
                type='submit' 
                name='delClasse' 
                id='delClasse'
                value='non' />
        </form>
<?php         }
    }
    ?>
</div>