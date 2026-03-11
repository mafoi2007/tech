<div id='body2'>
    <h1 class='alert'>Mettre à jour une classe</h1>
    <?php 
    if(isset($_GET['id'])){
        $classe = (int) urldecode($_GET['id']);
        $detailClasse = $config->getClasse($classe);
        if(empty($detailClasse)){
            echo "<h3 class='alert'>La Classe sollicitée n'existe pas.</h3>";
        }else{ 
            $listeNiveau = $config->listeNiveaux();
            $listeSection = $config->getSection();
            ?>
        <form method='post' action='../traitement.php'>
            <table border='1' width='100%'>
                <tr>
                    <th>Libelle</th>
                    <th>Anc. Valeur</th>
                    <th>Nouv. Valeur</th>
                </tr>
                <tr>
                    <th>Nom de la Classe</th>
                    <th><input type='text' value="<?php echo $detailClasse['nom_classe']; ?>" disabled /></th>
                    <th>
                        <input 
                            type='text'
                            name='nomClasse'
                            id='nomClasse'
                            value="<?php echo $detailClasse['nom_classe']; ?>"
                            required />
                    </th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th><input type='text' value="<?php echo $detailClasse['code_classe']; ?>" disabled /></th>
                    <th>
                        <input 
                            type='text'
                            name='codeClasse'
                            id='codeClasse'
                            value="<?php echo $detailClasse['code_classe']; ?>"
                            required />
                    </th>
                </tr>
                <tr>
                    <th>Niveau</th>
                    <th>
                        <select disabled>
                            <option><?php echo $detailClasse['nom_niveau']; ?></option>
                        </select>
                    </th>
                    <th>
                        <select name='niveau'>
                            <?php 
                            for($i=0;$i<count($listeNiveau);$i++){
                                $option = "<option value='";
                                $option .= $listeNiveau[$i]['id'];
                                $option .= "' ";
                                if($detailClasse['niveau_classe']==$listeNiveau[$i]['id']){
                                    $option .= "selected";
                                }
                                $option .= ">";
                                $option .= $listeNiveau[$i]['nom_niveau'];
                                $option .= "</option>";
                                echo $option;
                            }
                            ?>
                        </select>
                    </th>
                </tr>
                <tr>
                    <th>Section</th>
                    <th>
                        <select disabled>
                            <option><?php echo $config->transformSection($detailClasse['section']); ?></option>
                        </select>
                    </th>
                    <th>
                        <input 
                            type='hidden' 
                            name='classId' 
                            id='classId' 
                            value="<?php echo $detailClasse['id']; ?>" />
                        <select name='section'>
                            <?php 
                            for($i=0;$i<count($listeSection);$i++){
                                $option = "<option value='";
                                $option .= $listeSection[$i]['code_section'];
                                $option .= "' ";
                                if($detailClasse['section']==$listeSection[$i]['code_section']){
                                    $option .= "selected";
                                }
                                $option .= ">";
                                $option .= $config->transformSection($listeSection[$i]['code_section']);
                                $option .= "</option>";
                                echo $option;
                            }
                            ?>
                        </select>
                    </th>
                </tr>
                <tr>
                    <td colspan='4' align='center'>
                        <input 
                            type='submit'
                            name='upd_classe'
                            value='Mettre à Jour' />
                    </td>
                </tr>
            </table>
        </form>
<?php         }
    }
    ?>
</div>