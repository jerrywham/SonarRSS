<style>
	.form_content{box-shadow:0 1px 2px black;border-radius:3px;margin:auto; border:2px solid #000;font-family: 'georgia'; font-size:18px;background-color:#333;width:200px;padding:20px;text-shadow:0 1px 1px black;color:#ddd;}
	h1{font-size:22px; }
	.logo{margin: auto;background:url(design/img/logo.png) no-repeat;height:128px;width:128px;}
	label{display:block;}
	input[type=checkbox]+label{display:inline;width:auto;cursor:pointer;}
	input[type=checkbox]{display:inline;width:auto;}
	input{border-radius:3px;width:100%;}

	#login, #pass{border:1px solid #999;padding:3px;}
	#login:focus{text-shadow:0 0 3px green;}
	#pass:focus{text-shadow:0 0 3px red;}
	@media (max-width:600px){
		.form_content{width:90%;font-size:26px!important;}
		input{font-size:26px!important;}
	}
	@viewport{
    width: device-width;
    zoom:1;
	}
</style>

<div class="form_content">
	<form action='' method='post' name='' >
		<p class="logo"> </p>
		<?php if(file_exists('pass.php')){echo '<h1>Identifiez-vous</h1>';}else{echo '<h1>Creez votre passe</h1>';} ?>
			<hr/>
			<label for='login'>Login </label>
			<input type='text' name='login' id='login' required="required"/>
			<br/>
			<hr/>
		<label for='pass'>Passe </label>
		<input type='password' name='pass' id='pass'  required="required"/>	

		<hr/>
		<input id="cookie" type="checkbox" value="cookie" name="cookie"/><label for="cookie">Rest. connect.</label>
		<hr/>
		<input type='submit' value='Connexion'/>	
	</form>
</div>