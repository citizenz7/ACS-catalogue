<?php
include_once '../includes/config.php';
include_once 'header.php';

//if not logged in redirect to login page
if(!$user->is_logged_in()){
  header('Location: login.php');
}
?>

<div class="container pt-3 pb-5">
  <div class="row">
    <div class="col-sm-12 px-5 text-justify">
      <div class="pb-5">

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($username ==''){
			$error[] = 'Veuillez entrer un nom d\'utilisateur.';
		}

		if(strlen($password) > 0){

			if($password ==''){
				$error[] = 'Veuillez entrer un mot de passe.';
			}

			if($passwordConfirm ==''){
				$error[] = 'Veullez confirmer le mot de passe.';
			}

			if($password != $passwordConfirm){
				$error[] = 'Les mots de passe ne correspondent pas.';
			}

		}

		if($email ==''){
			$error[] = 'Veuillez entrer une adresse e-mail.';
		}

		if(!isset($error)){
			try {
				if(isset($password)){
					$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);
					//update into database
					$stmt = $db->prepare('UPDATE membres SET username = :username, password = :password, email = :email WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':password' => $hashedpassword,
						':email' => $email,
						':memberID' => $memberID
					));
				}
        else {
					//update database
					$stmt = $db->prepare('UPDATE membres SET username = :username, email = :email WHERE memberID = :memberID') ;
					$stmt->execute(array(
						':username' => $username,
						':email' => $email,
						':memberID' => $memberID
					));
				}

				//redirect to index page
				header('Location: users.php?action=updated');
				exit;
			}

      catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br>';
		}
	}

		try {
			$stmt = $db->prepare('SELECT memberID, username, email FROM membres WHERE memberID = :memberID') ;
			$stmt->execute(array(':memberID' => $_GET['id']));
			$row = $stmt->fetch();

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

  include_once 'menu.php';
  ?>

  <h2 class="pb-5">Editer l'utilisateur : <?php echo html($row['username']); ?></h2>

	<form action='' method='post'>
		<input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>

    <div class="form-group">
		   <label for="username">Pseudo</label>
		   <input type='text' name='username' class="form-control" value='<?php echo html($row['username']) ;?>'>
    </div>
    <div class="form-group">
		   <label for="password">Mot de passe (seulement en cas de changement)</label>
		   <input type='password' name='password' class="form-control" value=''>
    </div>
    <div class="form-group">
		   <label for="passwordConfirm">Confirm Password</label>
		   <input type='password' name='passwordConfirm' class="form-control" value=''>
    </div>
    <div class="form-group">
		   <label for="email">Email</label>
		   <input type='text' name='email' class="form-control" value='<?php echo html($row['email']) ;?>'>
    </div>

    <div class="text-right pt-5"><button type='submit' class="btn btn-primary" name='submit'>Editer cet utilisateur</button></div>

	</form>

</div>
</div>
</div>
</div>


<?php include_once 'footer.php'; ?>
