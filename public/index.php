<?php
require_once '../connec.php';

$pdo = new \PDO(DSN, USER, PASS);

$query = "SELECT * FROM association";
$statement = $pdo->query($query);

$associations = $statement->fetchAll(PDO::FETCH_ASSOC);


require '../src/function.php';

if($_SERVER ['REQUEST_METHOD'] === 'POST')
{
    $errors = [];

    $data = array_map('trim', $_POST);

    if(empty($data['lastname']))
    {
        $errors['lastnameErr'] = "Le nom est requis";
    }

    if(empty($data['firstname']))
    {
        $errors['firstnameErr'] = "Le prénom est requis";
    }

    if(empty($_POST['email']))
    {
        $errors['emailErr'] = "L'adresse mail est requise";
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            $errors['emailErr'] = "Format invalide";
    }

    if(empty($_POST['message']))
    {
        $errors['messageErr'] = "Un message est requis";
    }

    if (count($errors) == 0) {

        header("Location: success.php");
        exit();
    }
}

?>

<!--Partie HTML-->

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0' />
    <title>MY GREEN CITY</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php include "header.php"; ?>

<section>
    <div class="carousel">
        <h1 class="titre_gen">MY GREEN CITY</h1>
    </div>
</section>


<!----Partie Actions et Associations---->

<span id="actions"></span>

<?php include "../src/datas.php"; ?>

<section>
    <h2 class="title-actions">ORLÉANS EN ACTION</h2>
</section>
<section class="actions">
    <?php
    foreach ($actionsList as $actions => $value) {
        ?>
        <div class="action">
            <h2><?php echo $actions ?></h2>
            <a href="#"><img src="<?php echo $value['image'] ?>" alt="action"></a>
        </div>
        <?php
    }
    ?>
</section>

<hr>

<span id="associations"></span>


<section>
    <h2 class="title-assos">ASSOCIATIONS</h2>
</section>

<?php if (!empty($_GET['success'])) : ?>
    <div class="success_ok">L'association a bien été ajouté</div>
<?php endif; ?>
<?php if (!empty($_GET['delete'])) : ?>
    <div class="delete_ok">L'association a bien été supprimé</div>
<?php endif; ?>

<section class="assos">
       <?php
    foreach ($associations as $association) {

        ?>
        <div class="asso">
            <a href="association.php?id=<?= $association['id'] ?>"><img src="<?php echo $association['logo'] ?>" alt="asso" class="logo_asso"></a>
            <h2><?php echo htmlentities($association['asso_name']) ?></h2>
        </div>
        <?php
    }
    ?>
    <div>
        <a class="ajout" href="create.php"><img src="https://i.postimg.cc/m2PT4mnq/insertion-asso.jpg" alt="'insertion_asso" class="logo_insertion_asso"></a>
        <h2><a class="ajout" href="create.php">Ajouter une association</a></h2>
    </div>
</section>


<!--Partie gestion des dechets-->

<span id="dechets"></span>
<hr>

<article>
    <h2 class="titregestiondesdechets">GESTION DES DECHETS</h2>
    <h3 class="titreconseils">Conseils</h3>

    <div class="containerconseil">
        <p class="soustitre">Faites maigrir votre poubelle : des gestes faciles</p>

        <p class="paragrapheconseil"><span class="hovertext">1/ Choisir des  produits peu ou pas emballés (vrac, grand conditionnement, à la coupe...).</span> </p>

        <p class="paragrapheconseil"><span class="hovertext">2/ Choisir des produits avec des labels environnement: Ecolabel européen et Ecolabel français NF.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">3/ Faire son ménage avec des produits simples, peu polluants et économiques !</span></p>

        <p class="paragrapheconseil"><span class="hovertext">4/ Adopter les sacs réutilisables (cabas, paniers) et refuser les sacs jetables.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">5/ Coller un autocollant STOP PUB sur sa boîte aux lettres pour ne plus recevoir la publicité.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">6/ Limiter ses impressions et donc sa consommation de papier.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">7/ Boire l’eau du robinet plutôt que l’eau en bouteille.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">8/ Limiter sa consommation de piles et utiliser des piles rechargeables.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">9/ Prolonger la vie des objets : faire réparer, récupérer, donner, plutôt que jeter.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">10/ Faire soi-même le goûter des enfants, ses yaourts, cuisiner les restes.</span></p>

        <p class="paragrapheconseil"><span class="hovertext">11/ Utiliser pour votre bébé des couches lavables plutôt que jetables.</span></p>
    </div>
</article>

<?php include "../src/datas.php"; ?>

<article class="pointsdecollecte">
    <h3 class="titrecollecte">Points de collecte</h3>

    <div class="conteneur">
        <div class="cotegauche">
            <?php
            foreach ($pointsCollecte as $ville => $informations) { //boucle foreach permet de récupérer la clé et les valeurs du tableau pointdecollecte
                ?>
                <details>
                    <summary><?php echo $ville ?></summary>
                    <nav>
                        <ul>
                            <?php
                            foreach ($informations as $v) { //boucle foreach permet de récupérer les valeurs du tableau $informations
                                ?>
                                <li><?php echo $v ?></li>
                                <?php
                            }
                            ?>
                        </ul>
                    </nav>
                </details>
                <?php
            }
            ?>
        </div>
        <div class="imagecentre">
            <img class="imgcentre" src="https://proxy.duckduckgo.com/iu/?u=https%3A%2F%2Fwww.chavagnes-en-paillers.fr%2Fmedias%2F2016%2F03%2Fconteneurs-01.jpg&f=1&nofb=1" alt="Point de collecte" title="centre de tri"/>
        </div>
    </div>

</article>


<!--footer-->

<span id="contact"></span>

<section>
    <h2 class="contact">Contact</h2>

</section>
<?php include "formulaire.php" ; ?>

<?php include "footer.php" ; ?>
</body>
</html>

