<div id='body2'>
    <h1 class='alert'>Saisir ses Notes</h1>
    <?php $classe = $config->listClassProf($_SESSION['user']['id']); ?>
    <form method='post' action=''>
        Classe : 
            <select name='classe' id='classe' onChange='getMatiereAddNt()'>
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
if(isset($_POST['info'])){
    // echo '<pre>'; print_r($_POST); echo '</pre>';
    $classe = (int) $_POST['classe'];
    $matiere = (int) $_POST['subject'];
    $sequence = (int) $_POST['periode'];
    $nomClasse = $config->getClasse($_POST['classe']);
    $nomMatiere = $config->getMatiere($_POST['subject']);
    $nomSequence = $config->getSequenceCourante($_POST['periode']);
    $as = $config->getCurrentYear();
    $listeEleve = $config->listeEleve($nomClasse['id'], 'non_supprime', $as);
    require_once('../forms/ajouterNote.form.php');
}
    ?>
</div>