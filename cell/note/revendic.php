<div id='body2'>
    <h1 class='alert'>Révendication Séquentielle</h1>
    <?php $classe = $config->listClassSaisie(); 
    if(empty($classe)){
        echo "<h3 class='alert'>Vous n'avez encore saisi aucune note. Reportez-vous au Menu
                <i><u>Insérer des Notes</u></i> pour enregistrer vos notes.</h3>";
    }else{  ?>
    <form method='post' action=''>
        Classe : 
            <select name='classe' id='classe' onChange='getListeEleve()'>
                <option value='null' selected>-Choisir la Classe-</option>
                <?php
                for($i=0;$i<count($classe);$i++){
                    echo "<option value='".$classe[$i]['id_classe']."'>".$classe[$i]['nom_classe']."</option>";
                }
                ?>
            </select>
        <div id='matiere' style = 'display:inline'>
        </div>
    </form>
<?php 
    }




if(isset($_POST['info'])){
    // echo '<pre>'; print_r($_POST); echo '</pre>';
    $classe = (int) $_POST['classe'];
    $eleve = (int) $_POST['eleve'];
    $sequence = (int) $_POST['periode'];

    $infoEleve = $config->getEleve($eleve);
    $listeMatiere = $config->listeMatiereClasse($classe);
    $valeurNote = $config->getNoteEleve($eleve, $sequence);
    $infoSequence = $config->getSequenceCourante($sequence);
    // echo '<pre>'; print_r($valeurNote); echo '</pre>';
    require_once('../forms/revendicationNote.form.php');

}
    ?>
</div>