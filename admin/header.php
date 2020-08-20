<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="<?php echo $CHARSET; ?>">
    <title><?php echo $SITENAME; ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="../css/style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=0,viewport-fit=cover">
    <meta name="author" content="<?php echo $SITEAUTHORS; ?>">
    <meta name="keywords" content="<?php echo $SITEKEYWORD; ?>">
    <meta name="description" content="<?php echo $SITEDESCRIPTION; ?>">
    <link rel="apple-touch-icon" sizes="57x57" href="../img/icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../img/icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../img/icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../img/icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../img/icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../img/icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../img/icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../img/icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../img/icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="../img/icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../img/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../img/icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../img/icons/favicon-16x16.png">
    <link rel="manifest" href="../img/icons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="../img/icons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
    <script>
      tinymce.init({
        selector: "textarea",
        plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen",
          "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
      });
  </script>

  <!-- Suppression fiche artiste -->
  <script language="JavaScript" type="text/javascript">
    function delartiste(id, title) {
      if (confirm("Etes-vous certain de vouloir supprimer la fiche " + title + " ?")) {
        window.location.href = 'index.php?delartiste=' + id;
      }
    }
  </script>

  <!-- Suppression de l'image de l'artiste/groupe -->
  <script language="JavaScript" type="text/javascript">
  function delimage(id, title) {
    if (confirm("Etes-vous certain de vouloir supprimer l'image pour '" + title + "'")) {
      window.location.href = 'edit.php?delimage=' + id;
    }
  }
  </script>

  </head>
  <body>
<?php //include_once 'sidebar.php'; ?>

<div class="container">

  <nav class="navbar navbar-expand-lg navbar-light my-3" style="background-color: #cce5ff;">
    <a class="navbar-brand" href="../"><?php echo $SITENAME; ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="../">Accueil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../contact.php">Contact</a>
        </li>
        <!--
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Artistes/Groupes
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#">Tri par genre</a>
            <a class="dropdown-item" href="#">Tri par pays origine</a>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="./">Admin</a>
            <a class="dropdown-item" href="../archives.php">Archives</a>
          </div>
        </li>
      -->
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ok</button>
      </form>
    </div>
  </nav>

<?php //include_once '../menu.php'; ?>
