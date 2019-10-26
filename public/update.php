<?php
require_once '../connec.php';

$pdo = new PDO(DSN, USER, PASS);
$id = $_GET['id'] ?? $_POST['id'] ?? '';
$statement = $pdo->prepare("SELECT * FROM association WHERE id=:id");

$statement->bindValue(':id', $id, PDO::PARAM_INT);

$statement->execute();

$association = $statement->fetch(PDO::FETCH_ASSOC);

if($_SERVER ['REQUEST_METHOD'] === 'POST') {
    // clean $_POST
    $data = array_map('trim', $_POST);

    //vérification des données
    $errors = [];

    if (empty($data['asso_name'])) {
        $errors['asso_nameErr'] = "Le nom de l'association est requis";
    } else {
        if (strlen($data['asso_name']) > 100)
            $errors['asso_nameErr'] = 'Le nom de l\'association ne doit pas depasser 100 caractères';
    }

    if (empty($data['adresse'])) {
        $errors['adresseErr'] = "Une adresse est requise";
    } else {
        if (strlen($data['adresse']) > 255)
            $errors['adresseErr'] = 'L\'adresse ne doit pas depasser 255 caractères';
    }

    if (empty($data['mail'])) {
        $errors['mailErr'] = "Une adresse mail est requise";
    } else {
        if (!filter_var($data['mail'], FILTER_VALIDATE_EMAIL))
            $errors['mailErr'] = "Format invalide";
    }

    if (empty($data['telephone'])) {
        $errors['telephoneErr'] = "Un numéro de téléphone est requis";
    } else {
        if (strlen($data['telephone']) > 14)
            $errors['telephoneErr'] = 'Le numéro de téléphone ne doit pas depasser 14 caractères';
    }

    if (empty($data['lien_site'])) {
        $errors['lien_siteErr'] = "Le lien du site est requis";
    }

    if (empty($data['logo'])) {
        $errors['logoErr'] = "Un logo est requis";
    }

    if (empty($data['content'])) {
        $errors['contentErr'] = "Un contenu est requis";
    }

    // Si pas d'erreurs
    if (empty($errors)) {

        // Requête Insertion
        $query = "UPDATE association SET asso_name=:asso_name, adresse=:adresse, mail=:mail, telephone=:telephone, lien_site=:lien_site, logo=:logo, content=:content WHERE id=:id";
        $statement = $pdo->prepare($query);

        $statement->bindValue(':asso_name', $data['asso_name'], PDO::PARAM_STR);
        $statement->bindValue(':adresse', $data['adresse'], PDO::PARAM_STR);
        $statement->bindValue(':mail', $data['mail'], PDO::PARAM_STR);
        $statement->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
        $statement->bindValue(':lien_site', $data['lien_site'], PDO::PARAM_STR);
        $statement->bindValue(':logo', $data['logo'], PDO::PARAM_STR);
        $statement->bindValue(':content', $data['content'], PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT); // ne pas oublier pour la modification

        $statement->execute();

        // redirection
        header('Location: association.php?id='. $data['id'].'&success=ok');
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="style_asso.css">
    <title>Modification association</title>
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

<h1 class="title_update">Modification de l' association </h1>
<h2 class="title_asso_update"><?= htmlentities($association['asso_name'])?></h2>
<main>
    <div>
        <form class="form_create" method="POST">
            <input type="hidden" name="id" value="<?= $association['id'] ?>">
            <div>
                <label for="asso_name">Nom de l'association</label>
                <input class="form-control" type="text" id="asso_name" name="asso_name" value="<?php echo $association['asso_name']; ?>">
            </div>
            <div>
                <label for="adresse">Adresse</label>
                <input class="form-control" type="text" id="adresse" name="adresse" value="<?php echo $association['adresse']; ?>">
            </div>
            <div>
                <label for="mail">E-mail</label>
                <input class="form-control" type="text" id="mail" name="mail" value="<?php echo $association['mail']; ?>">
            </div>
            <div>
                <label for="telephone">Numéro de téléphone</label>
                <input class="form-control" type="tel" id="telephone" name="telephone" value="<?php echo $association['telephone']; ?>">
            </div>
            <div>
                <label for="lien_site">Lien du site internet</label>
                <input class="form-control" type="text" id="lien_site" name="lien_site" value="<?php echo $association['lien_site']; ?>">
            </div>
            <div>
                <label for="logo">Logo</label>
                <input class="form-control" type="text" id="logo" name="logo" value="<?php echo $association['logo']; ?>">
            </div>
            <div>
                <label for="content">Contenu</label>
                <textarea class="form-control" id="content" name="content"><?php echo $association['content']; ?></textarea>
            </div>
            <button class="btn-update" OnClick="return confirm('Voulez-vous vraiment modifier l\'article ?');">Modifier l' association</button>
        </form>

    </div>
</main>

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
