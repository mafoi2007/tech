<?php
	session_start();
	require_once('../../inc/connect.inc.php');
	$config = new config($db);
    $as = $config->getCurrentYear();
    $reponse = (int) $_POST['user'];
    if(empty($reponse)){
        echo "<h3 class='alert'>Vous devez faire un choix valide.</h3>";
    }else{
        $userInfo = $config->getUser($reponse);
        $userName = $userInfo['nom'];
        $userId = $userInfo['id']; ?>
    <h3></h3>
    <table border='0' width='60%'>
        <tr>
            <th colspan = '2'>Réinitialiser le mot de passe de 
                <font class='alert'><i><?php echo stripslashes($userName); ?></i></font>
            </th>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Entrez un nouveau mot de passe :</td>
            <td><input type='password' name='userPwd' id='userPwd' required/></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><b class='alert'>Confirmez le nouveau</b> mot de passe :</td>
            <td><input type='password' name='userPwdCfm' id='userPwdCfm' required /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
         <tr>
            <td colspan='2' align='center'><input type='submit' name='resetPwd' value='Modifier' /></td>
        </tr>
    </table>

<?php 
    }
    
   

    