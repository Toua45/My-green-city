<?php
require_once '../connec.php';

$id = $_GET['id'];

$pdo = new PDO(DSN, USER, PASS);

$statement = $pdo->prepare("SELECT * FROM association WHERE id=:id");
$statement->bindValue(':id', $id, PDO::PARAM_INT);

$statement->execute();

$association = $statement->fetch(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="style_asso.css">
    <title>association</title>
</head>
<body>

<header>
    <nav class="navbar">
        <div class="links" id="menu">
            <a class ="boutton_accueil" href="index.php">Accueil</a>
            <a class ="boutton_logo" href="index.php"><img src="https://i.postimg.cc/bw2v17Rh/logo.jpg" class="logo_eco" alt="logo"></a>
            <a class ="boutton"  href="index.php#actions">Actions</a>
            <a class ="boutton"  href="index.php#associations">Associations</a>
            <a class ="boutton"  href="index.php#dechets">Dechets</a>
            <a class ="boutton"  href="index.php#contact">Contact</a>
            <a class="close" href="#">X</a>
        </div>
        <a class="burger" href="#menu">Menu</a>
    </nav>
</header>

<section>
<h1 class="titre_asso"><?= htmlentities($association['asso_name']) ?></h1>
    <?php if (!empty($_GET['success'])) : ?>
        <div class="success">L'association a bien été modifié</div>
    <?php endif; ?>
    <div class="fond">

    <h2 class="info">Informations</h2>

    <div class="information">

    <div class="cadre_gauche">
        <p class="asso_infos"><?= htmlentities($association['adresse']) ?><p>
        <p class="asso_infos"><?= htmlentities($association['mail']) ?></p>
        <p class="asso_infos"><?= htmlentities($association['telephone']) ?></p>
        <p class="asso_infos"><?= htmlentities($association['lien_site']) ?></p>
    </div>

    <div class="cadre_droit">
        <img class="asso_logo" src="<?= $association['logo'] ?>" alt="asso_logo">
    </div>
    </div>
</div>
<main class="container">

    <h2 class="asso_des">Description</h2>

    <div class="description">
        <p class="text_asso"><?= htmlentities($association['content']) ?></p>
    </div>
    <form class="form_association" action="delete.php" method="POST">
        <input name="id" type="hidden" value="<?= $association['id'] ?> "/>
        <button class="danger" OnClick="return confirm('Voulez-vous vraiment supprimer ?');">Supprimer l' association</button>
        <a class="add_asso" href=update.php?id=<?= $association['id'] ?>">Modifier l'association</a>
    </form>
</main>
</section>

<footer>

    <nav class="partie_footer">
        <div class="texte_debut">
            <h3 class="titre_formulaire">Découvrir Eco Green 45</h3>
            <a href="a-propos" title="À propos">À propos</a>
            <a href="partenaires" title="partenaires">Partenaires</a>
            <a href="conditions-d'utilisation" title="Conditions d'utilisation">Conditions d'utilisation</a>
        </div>


        <div class="texte_milieu">
            <h3 class="titre_formulaire">Mentions légales</h3>
            <a href="mentions-légales" title="Mentions légales">Mentions légales</a>
            <a href="confidentialités" title="Confidentialités">Confidentialités</a>
            <a href="cookies" title="Cookies">Cookies</a>
        </div>

        <div class="texte_fin">
            <h3 class="titre_form">Infos</h3>
            <a href="faq" title="FAQ">FAQ</a>
            <a href="publicités" title="Publicités">Publicités</a>
            <a href="plan-du-site" title="Plan du site">Plan du site</a>
        </div>
    </nav>


    <div class="footer2">
        <a href="https://fr-fr.facebook.com/" target="_blank">
            <img class="logo" src="https://zupimages.net/up/19/38/ja8c.png" alt="Logo de Facebook"></a>
        <a href="https://twitter.com/" target="_blank">
            <img class="logo" src="https://zupimages.net/up/19/38/c3am.png" alt="Logo de Twitter"></a>
        <a href="https://www.youtube.com/" target="_blank">
            <img class="logo" src="https://zupimages.net/up/19/38/n1w4.png" alt="Logo de Youtube"></a>
        <a href="http://www.orleans-metropole.fr/" target="_blank">
            <img class="logo_orleans" src="https://zupimages.net/up/19/38/7zqe.png" alt="Logo d'Orléans"></a>
    </div>

    <div class="footer3">
        <a href="termes-et-conditions" title="Termes et conditions">Conditions générales d'utilisation</a>
        <a href="politique-de-confidentialité" title="politique de confidentialité">Politique de confidentialité</a>
        <p class="copy">© Copyright 2019 : Toua, Alexandre, Daniel, Lionel, Mathias</p>
    </div>



</footer>


</body>
</html>

