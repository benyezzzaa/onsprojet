<?php

require_once('Modele/Register.php');
require_once('Modele/Recherche.php');

class ControleurRecherche implements Controleur
{

   
    private $recherche;


    
    public function __construct()
    {
        $this->recherche = new Recherche();
    }

    
    public function getRecherche()
    {
        return $this->recherche;
    }

    
    public function setRecherche($newRecherche)
    {
        $this->user = $newRecherche;
    }


    
    public function getSearchModule()
    {
        if (empty($_POST['produitName'])) {
        }
    }


    
    public function getHTML()
    {
        $vue = new Vue("Recherche");
        if (!empty($_POST['searchName'])) {
            $produitsList = $this->recherche->getProduitByName($_POST['searchName']);
            if (isset($produitsList)) {
                if (count($produitsList) == 1) { 
                    header('Location: index.php?action=productCategorie&id=' . $produitsList[0]['produitID']); 
                    die();
                } else { 
                    $vue->generer(array("produitsSearch" => $produitsList));
                }
            } else
                $vue->generer(array("error" => Recherche::NO_RESULT));
        } else
            $vue->generer(array("produitsSearch" => ""));
    }
}

?>
