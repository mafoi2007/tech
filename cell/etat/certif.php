<div id='body2'>
    <h1 class='bien'>Certificat de Scolarité</h1>
	<form method='post' action='../traitement.php' target='_blank'>
		<p>
			Entrer le nom ou une partie du nom : 
			<input 
				type='text' 
				name='nomEleve' 
				id='nomEleve' 
				placeholder='Entrer une partie du nom'
				onKeyup='findEleve()' />
		</p>
		<div id='resultat' style = 'display:inline'>	
		</div>
	</form>
</div>