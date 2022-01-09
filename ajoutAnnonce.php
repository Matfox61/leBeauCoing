<?php
require_once("<?php echo Racine; ?>inclusions/init.php");

// Modification d'une annonce
if(isset($_GET['action']) && $_GET['action'] == "modification")
{
    $resultat = executeRequete("SELECT * FROM annonce WHERE reference=$_GET[reference]");
    $annonce_actuelle = $resultat->fetch_assoc();
}

//--- ENREGISTREMENT ANNONCE ---//
if(!empty($_POST))
    // on enregistre les donnée
{   //debug($_POST);

    $photo_bdd = "";
    
    if(!empty($_FILES['photo']['name']))
    {   //debug($_FILES);
        $nom_photo = $_FILES['photo']['name'];
        $photo_bdd = "<?php echo Racine; ?>photo/$nom_photo";   // Fichier source
        $photo_dossier = $_SERVER['DOCUMENT_ROOT'] . "/photo/$nom_photo";   // Fichier destination
        move_uploaded_file($_FILES['photo']['tmp_name'],$photo_dossier);
        if (!move_uploaded_file($photo_bdd, $photo_dossier)) {
            echo "La copie  du fichier $photo_bdd a échoué...\n";
        }


    }
    foreach($_POST as $indice => $valeur)
    {
        $_POST[$indice] = htmlEntities(addSlashes($valeur));
    }

    
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $photo_bdd = $_POST['photo_actuelle'];
        executeRequete("REPLACE INTO annonce (reference, secteur, titre, description, photo, prix, estEnLigne) values ('$_GET[reference]', '$_POST[secteur]', '$_POST[titre]', '$_POST[description]', '$photo_bdd', '$_POST[prix]', '$_POST[estEnLigne]')");
        $contenu .= '<div class="validation">L\'annonce a été modifiée avec succès</div>'; 

    }
    else
    {
        executeRequete("INSERT INTO annonce (secteur, titre, description, photo, prix) values ('$_POST[secteur]', '$_POST[titre]', '$_POST[description]', '$photo_bdd', '$_POST[prix]')");
        $contenu .= '<div class="validation">L\'annonce a été ajoutée</div>';

    }
}

//--------------------------------- AFFICHAGE HTML ---------------------------------//
require_once("./inclusions/haut.php");
echo $contenu;
?>
<h1> Ajouter une Annonce </h1>
<form method="POST" enctype="multipart/form-data" action="">
 
    <label for="secteur">Secteur</label><br>
    <input type="text" id="secteur" name="secteur" value="<?php echo $annonce_actuelle['secteur']?>" placeholder="Secteur">
    <?php if(isset($_POST['submit']) && empty($_POST['secteur'])) echo '<p style="color:#ff0000;">Veuillez compléter ce champs</p>'; ?>
    <br><br>

    <label for="titre">titre</label><br>
    <input type="text" id="titre" name="titre" value="<?php echo $annonce_actuelle['titre']?>"placeholder="Titre">
    <?php if(isset($_POST['submit']) && empty($_POST['titre'])) echo '<p style="color:#ff0000;">Veuillez compléter ce champs</p>'; ?>
    <br><br>

    <label for="description">description</label><br>
    <textarea contenteditable="true" name="description" id="description"><?php echo $annonce_actuelle['description']?></textarea>
    <script type="text/javascript">
        CKEDITOR.replace("description");
    </script>
    <br><br>
     
    <label for="photo">photo</label><br>
    <input type="file" id="photo" name="photo"><br><br>
 
    <label for="prix">prix</label><br>
    <input type="text" id="prix" name="prix" value="<?php echo $annonce_actuelle['prix']?>"placeholder="Prix">
    <?php if(isset($_POST['submit']) && empty($_POST['prix'])) echo '<p style="color:#ff0000;">Veuillez compléter ce champs</p>'; ?>
    <br><br>

    <label for="estEnLigne">Mettre l'annonce en ligne ?</label><br>
    <input type="radio" id="oui" name="estEnLigne" value="1">
    <label for="estEnLigne">Oui</label><br>
    <input type="radio" id="non" name="estEnLigne" value="0" checked>
    <label for="estEnLigne">Non</label><br><br>

   
    <input type="submit" name="submit" value="Publier l'annonce">
</form>
<?php require_once("inclusions/bas.php"); ?>