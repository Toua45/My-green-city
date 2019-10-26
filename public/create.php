<?php
require_once '../connec.php';

$pdo = new \PDO(DSN, USER, PASS);

if($_SERVER ['REQUEST_METHOD'] === 'POST') {
    // clean $_POST
    $data = array_map('trim', $_POST);

    //vérification des données
    $errors = [];

    if (empty($data['asso_name'])) {
        $errors['asso_nameErr'] = "Le nom est requis";
    } else {
        if (strlen($data['asso_name']) > 100)
            $errors['asso_nameErr'] = 'Le nom ne doit pas depasser 100 caractères';
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
        $query = "INSERT INTO association (asso_name, adresse, mail, telephone, lien_site, logo, content) VALUES (:asso_name, :adresse, :mail, :telephone, :lien_site, :logo, :content)";
        $statement = $pdo->prepare($query);

        $statement->bindValue(':asso_name', $data['asso_name'], PDO::PARAM_STR);
        $statement->bindValue(':adresse', $data['adresse'], PDO::PARAM_STR);
        $statement->bindValue(':mail', $data['mail'], PDO::PARAM_STR);
        $statement->bindValue(':telephone', $data['telephone'], PDO::PARAM_STR);
        $statement->bindValue(':lien_site', $data['lien_site'], PDO::PARAM_STR);
        $statement->bindValue(':logo', $data['logo'], PDO::PARAM_STR);
        $statement->bindValue(':content', $data['content'], PDO::PARAM_STR);

        $statement->execute();
        // redirection
        header('Location: index.php?success=ok#associations');
        exit();
    }
}
?>

<!--Partie HTML-->
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="style_asso.css">
    <title>Création association</title>
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
<h1 class="title_create">Création d'une association</h1>

<main>
    <div>
        <form class="form_create" method="POST" action="">
            <div>
                <label for="asso_name">Nom de l'association</label>
                <input class="form-control" type="text" id="asso_name" name="asso_name" value="<?php if(isset($data['asso_name'])) echo $data['asso_name']; ?>" required>
                <span class="error"><?php if(isset($errors['asso_nameErr'])) echo $errors['asso_nameErr'];?></span/>
            </div>
            <div>
                <label for="adresse">Adresse</label>
                <input class="form-control" type="text" id="adresse" name="adresse" value="<?php if(isset($data['adresse'])) echo $data['adresse']; ?>" required>
                <span class="error"><?php if(isset($errors['adresseErr'])) echo $errors['adresseErr'];?></span>
            </div>
            <div>
                <label for="mail">E-mail</label>
                <input class="form-control" type="text" id="mail" name="mail" value="<?php if(isset($data['mail'])) echo $data['mail']; ?>" required>
                <span class="error"><?php if(isset($errors['mailErr'])) echo $errors['mailErr'];?></span>
            </div>
            <div>
                <label for="telephone">Numéro de téléphone</label>
                <input class="form-control" type="tel" id="telephone" name="telephone" value="<?php if(isset($data['telephone'])) echo $data['telephone']; ?>" required>
                <span class="error"><?php if(isset($errors['telephoneErr'])) echo $errors['telephoneErr'];?></span>
            </div>
            <div>
                <label for="lien_site">Lien du site internet</label>
                <input class="form-control" type="text" id="lien_site" name="lien_site" value="<?php if(isset($data['lien_site'])) echo $data['lien_site']; ?>" required>
                <span class="error"><?php if(isset($errors['lien_siteErr'])) echo $errors['lien_siteErr'];?></span>
            </div>
            <div>
                <label for="logo">Logo</label>
                <input class="form-control" type="text" id="logo" name="logo" value="<?php if(isset($data['logo'])) echo $data['logo']; ?>" required>
                <span class="error"><?php if(isset($errors['logoeErr'])) echo $errors['logoErr'];?></span>
            </div>
            <div>
                <label for="content">Contenu</label>
                <textarea class="form-control" id="content" name="content"><?php if(isset($data['content'])) echo $data['content']; ?></textarea>
            </div>
            <button class="btn-add" type="submit" name="ajout" value="submit">Ajouter une association</button>
        </form>

    </div>
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