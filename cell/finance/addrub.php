<div id='body2'>
    <h1 class='alert'>Créer une rubrique</h1>
    <form method='post' action='../traitement.php'>
        <table border='0' width='75%' align='center'>
            <tr>
                <td>Nom de la Rubrique</td>
                <td>
                    <input 
                        type='text'
                        name='nomRubrique'
                        id='nomRubrique'
                        placeholder='Nom de la Rubrique'
                        size='30'
                        required />
                </td>
            </tr>
            <tr>
                <td colspan='2'>&nbsp;</td>
            </tr>
            <tr>
                <td>Code de la Rubrique</td>
                <td>
                    <input 
                        type='text'
                        name='codeRubrique'
                        id='codeRubrique'
                        placeholder='Code de la Rubrique'
                        size='30'
                        required />
                </td>
            </tr>
            <tr>
                <td colspan='2'>&nbsp;</td>
            </tr>
            <tr>
                <td align='center'>
                    <input 
                        type='submit'
                        name='finance'
                        value='Ajouter' />
                    <input 
                        type='hidden'
                        name='nature'
                        value='addRubrique' />
                </td>
                <td align='center'>
                    <input 
                        type='reset'
                        name='addRubrique'
                        value='Effacer' />
                </td>
            </tr>
        </table>
    </form>
</div>