<?php

require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/Produit.php';

class ControleurProduitList implements Controleur
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
        $vue = new Vue("ProduitList");
        $vue->generer(array('ProduitList' => $this->produit->getAllProduit()));
    }


}
