<?php


require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';


class ControleurProductCategorie implements Controleur
{
   
    private $produit;


    
    public function __construct()
    {
        $this->produit = new Produit();
    }

    
    public function getProduit()
    {
        return $this->produit;
    }

    
    public function setProduit($newProduct)
    {
        $this->produit = $newProduct;
    }


    
    public function getHTML()
    {
        if (isset($_GET['idCategorie'])) { 
            $vue = new Vue("ProduitList");
            $vue->generer(array("ProduitList" => $this->produit->getAllProduitsByCategorieId($_GET['idCategorie'])));
        } else if (isset($_GET['id']) && !isset($_GET["do"])) {  
           
            $vue = new Vue("Produit");
            $vue->generer(array(
                "add_panier" => false,
                "produit" => $this->getProduit()->getProduit($_GET['id'])));
        } else if (isset($_GET['do']) && isset($_GET['id'])) { 
            if (!isset($_SESSION['userID'])) 
                return;
            if ($_GET['do'] == "addPanier") {
                $vue = new Vue("Produit");
                $vue->generer(array(
                    "add_panier" => $this->addProduitToPanier($_GET['id']),
                    "produit" => $this->getProduit()->getProduit($_GET['id']),
                ));
            }
        } else {
            
        }
    }


    public function addProduitToPanier($produitID)
    {
       
        if (!isset($_SESSION['userID'])) {
            
            echo "Veuillez vous connecter";
            header('Location: index.php?action=login');
            return;
        }
        
        $panier = $this->produit->getPanierForUser($_SESSION['userID']);
        if ($panier == null) {
            
            $this->produit->createNewPanier($_SESSION['userID']);
            $panier = $this->produit->getPanierForUser($_SESSION['userID']);
        }
        $ligne_panier = $this->produit->getLignePanier($panier['panierID'], $produitID);
        if ($ligne_panier == null) 
            $ligne_panier = $this->produit->createNewLignePanier($panier['panierID'], $produitID);
        else
            $this->produit->increaseQuantityPanier($ligne_panier['lignePanierID']);

        return true;
    }

}