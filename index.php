<?php
require_once("./inclusions/init.php");

if(isset($_GET['action']) && $_GET['action'] == "suppression")
{  
    $resultat = executeRequete("SELECT * FROM annonce WHERE reference=$_GET[reference]");
    $annonce_a_supprimer = $resultat->fetch_assoc();
    $chemin_photo_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . $annonce_a_supprimer['photo'];
    if(!empty($annonce_a_supprimer['photo']) && file_exists($chemin_photo_a_supprimer)) unlink($chemin_photo_a_supprimer);
    executeRequete("DELETE FROM annonce WHERE reference=$_GET[reference]");
    $contenu .= '<div class="validation">Suppression de l\'annonce : ' . $_GET['reference'] . '</div>';
}
$resultat = executeRequete("SELECT * FROM annonce");
$contenu .= '<a class="btn-outline-primary" href="ajoutAnnonce.php">Ajouter une annonce</a><br/><br/>';

$contenu .= $resultat->num_rows . ' annonces trouvée(s)';
$contenu .= '<table  ><tr>';
     
    while($colonne = $resultat->fetch_field())
    {    
        $contenu .= '<th>' . $colonne->name . '</th>';
    }
    $contenu .= '<th>Modification</th>';
    $contenu .= '<th>Supression</th>';
    $contenu .= '</tr>';
 
    while ($ligne = $resultat->fetch_assoc())
    {
        $contenu .= '<tr>';
        foreach ($ligne as $indice => $information)
        {
            if($indice == "photo")
            {
                $contenu .= '<td><img src="' . $information . '" ="70" height="70"></td>';
            }
            else if($indice == "prix")
            {
                $contenu .= '<td>' . $information . '€</td>';
            }
            else if($indice == "description")
            {
                $contenu .= '<td>' . html_entity_decode($information) . '</td>';
            }
            else if($indice == "estEnLigne")
            {
                if($information == '1') $contenu .= '<td>Oui</td>';
                else $contenu .= '<td>Non</td>';
            }
            else
            {
                $contenu .= '<td>' . $information . '</td>';
            }
        }
        $contenu .= '<td><a href="ajoutAnnonce.php?action=modification&reference=' . $ligne['reference'] .'">Modifier</a></td>';
        $contenu .= '<td><a href="?action=suppression&reference=' . $ligne['reference'] .'" OnClick="return(confirm(\'En êtes vous certain ?\'));">Supprimer</a></td>';
        $contenu .= '</tr>';
    }
    $contenu .= '</table><br><hr><br>';


// AFFICHAGE
require_once("inclusions/haut.php");
echo $contenu;



require_once("inclusions/bas.php"); 

?>