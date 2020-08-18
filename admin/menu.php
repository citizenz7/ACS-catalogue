<nav class="navbar navbar-expand-sm navbar-dark bg-dark mb-4">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fas fa-users-cog"></i> Page admin</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../" target="_blank"><i class="fas fa-home"></i> Page d'accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="users.php"><i class="fas fa-users"></i> Utilisateurs</a>
      </li>
    </ul>
	<?php
	if(!$user->is_logged_in()){
		echo '<span class="navbar-text"><a class="text-white" href="login.php"><i class="fas fa-sign-in-alt"></i> Connexion</a></span>';
	}
	else {
		echo '<span class="navbar-text"><a class="text-white" href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a></span>';
	}
	?>
  </div>
</nav>
