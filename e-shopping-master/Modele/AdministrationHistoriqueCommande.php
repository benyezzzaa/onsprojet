<?php

require_once('Modele.php');


class AdministrationHistoriqueCommande extends Modele
{


    
    public function getAllPanier()
    {
        $sql = ' select panierID, nom, etatPanier from panier INNER JOIN user where panier.userID=user.userID';
        $panier = $this->executerRequete($sql);
        return $panier;

    }


    
    public function getPanier($panierID)
    {
        $sql = 'select panierID, nom, etatPanier from panier INNER JOIN user where panier.userID=user.userID and panier.panierID=?';
        $panier = $this->executerRequete($sql, array($panierID));
        return $panier;

    }


    
    public function getCommande($panierID)
    {
        $sql = ' select quantité, nomProduit, prix from lignepanier inner join produit where lignepanier.produitID=produit.produitID and panierID=?';
        $commande = $this->executerRequete($sql, array($panierID));
        return $commande;
    }


    
    public function getPanierUser($userName)
    {
        $sql = " select panierID, nom, etatPanier FROM panier INNER JOIN user where panier.userID=user.userID and user.nom=?";
        $panier = $this->executerRequete($sql, array($userName));
        return $panier;
    }


    
    public function turnPaid($panierID)
    {
        $sql = "UPDATE panier SET etatPanier = 1 WHERE panierID = ?";
        $this->executerRequete($sql, array($panierID));

    }


        public function turnNotPaid($panierID)
    {
        $sql = "UPDATE panier SET etatPanier = 0 WHERE panierID = ?";
        $this->executerRequete($sql, array($panierID));
    }


}