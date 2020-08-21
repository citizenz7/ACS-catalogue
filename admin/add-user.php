<?php

//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){
   header('Location: login.php');
}

$pagetitle = 'Nous contacter';
include_once 'header.php';
?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 text-justify">
      <div class="pb-5">

<?php
//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($username ==''){
			$error[] = 'Veuuillez entrer un pseudo.';
		}

		if($password ==''){
			$error[] = 'Veuullez entrer un mot de passe.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Veuillez confirmer le mot de passe.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Les mots de passe ne correspondent pas.';
		}

		if($email ==''){
			$error[] = 'Veuillez entrer une adresse e-mail.';
		}

		if(!isset($error)){

			$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO membres (username,password,email) VALUES (:username, :password, :email)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $hashedpassword,
					':email' => $email
				));

				//redirect to index page
				header('Location: users.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

  <?php
  include('./menu.php');
  ?>

  <div class="pt-3 pb-3"><h2>Ajouter un utilisateur</h2></div>

	<form action='' method='post'>

    <div class="form-group">
		  <label for="username">Pseudo</label>
		  <input type='text' name='username' class="form-control" value='<?php if(isset($error)){ echo $_POST['username'];}?>'>
    </div>

    <div class="form-group">
		  <label for="password">Mot de passe</label>
		  <input type='password' name='password' class="form-control" value='<?php if(isset($error)){ echo $_POST['password'];}?>'>
    </div>

    <div class="form-group">
		  <label for="passwordConfirm">Confirmez le mot de passe</label>
		  <input type='password' name='passwordConfirm' class="form-control" value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'>
    </div>

    <div class="form-group">
		  <label for="email">E-mail</label>
		  <input type='text' name='email' class="form-control" value='<?php if(isset($error)){ echo $_POST['email'];}?>'>
    </div>

    <div class="text-right"><button type='submit' class="btn btn-primary" name='submit'>Ajouter un utilisateur</button></div>

	</form>

</div>
</div>
</div>
</div>
</div>
</div>

<?php include_once 'footer.php'; ?>
