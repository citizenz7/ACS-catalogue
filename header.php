<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="<?php echo $CHARSET; ?>">
    <title><?php echo $SITENAME; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="./css/style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0,viewport-fit=cover">
    <meta name="author" content="<?php echo $SITEAUTHORS; ?>">
    <meta name="keywords" content="<?php echo $SITEKEYWORD; ?>">
    <meta name="description" content="<?php echo $SITEDESCRIPTION; ?>">
  </head>
  <body>
<?php //include_once 'sidebar.php'; ?>

<div class="container">

<nav class="navbar navbar-expand-lg navbar-light my-3" style="background-color: #cce5ff;">
  <a class="navbar-brand" href="./"><?php echo $SITENAME; ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="./">Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Artistes/Groupes
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Tri par genre</a>
          <a class="dropdown-item" href="#">Tri par pays origine</a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="./admin">Admin</a>
          <a class="dropdown-item" href="archives.php">Archives</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ok</button>
    </form>
  </div>
</nav>
