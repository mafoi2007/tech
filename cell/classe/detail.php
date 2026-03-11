<div id="body2">
   <?php 
   if(isset($_GET['id'])){
        $classe = (int) urldecode($_GET['id']);
        $detailClasse = $config->getClasse($classe);
        if(empty($detailClasse)){
            echo "<h3 class='alert'>La Classe sollicitée n'existe pas.</h3>";
        }else{ ?>
        <table border='1' width='75%'>
            <tr>
                <th>Nom de la Classe</th>
                <th><?php echo $detailClasse['nom_classe']; ?></th>
            </tr>
            <tr>
                <th>Code</th>
                <th><?php echo $detailClasse['code_classe']; ?></th>
            </tr>
            <tr>
                <th>Niveau</th>
                <th><?php echo $detailClasse['nom_niveau']; ?></th>
            </tr>
            <tr>
                <th>Section</th>
                <th><?php echo $config->transformSection($detailClasse['section']); ?></th>
            </tr>
            <caption>Détail sur la classe</caption>
        </table>
<?php         }
        // echo '<pre>';print_r($detailClasse); echo '</pre>';
   }
   ?>
</div>