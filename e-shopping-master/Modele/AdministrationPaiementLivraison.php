<?php


class AdministrationPaiementLivraison extends Modele
{
    
    const ACTION_OK = 1;
    const INVALID_PARAMETER = 2;
    const MISSING_PARAMETERS = 3;
    const BAD_ITEM_EDIT = 4;
    const EDIT_OK = 5;


    
    public function insertPaiementLivraison($nom, $description)
    {
        $sql = "INSERT INTO moyendepaiement(moyenDePaiementID,nomMoyenDePaiement,descriptionMoyenDePaiement) VALUES (NULL, ?, ?)";
        $this->executerRequete($sql, array($nom, $description));
        return AdministrationPaiementLivraison::ACTION_OK;
    }


    
    public function removePaiementLivraison($paiementID)
    {
        $sql = "DELETE FROM moyendepaiement WHERE moyenDePaiementID = ?";
        $this->executerRequete($sql, array($paiementID));
        return AdministrationPaiementLivraison::ACTION_OK;
    }


    
    public function editMoyenPaiement($nom, $description, $paiementID)
    {
        $sql = "UPDATE moyendepaiement SET nomMoyenDePaiement = ?, descriptionMoyenDePaiement = ? WHERE moyenDePaiementID = ?";
        $this->executerRequete($sql, array($nom, $description, $paiementID));
        return AdministrationPaiementLivraison::EDIT_OK;
    }


    
    public function getMoyensPaiement()
    {
        $sql = "SELECT * FROM moyendepaiement";
        $moyensPaiement = $this->executerRequete($sql);
        if ($moyensPaiement->rowCount() > 0)
            return $moyensPaiement->fetchAll();
        else
            return array();
    }


    
    public function getMoyensPaiementById($paiementID)
    {
        $sql = "SELECT * FROM moyendepaiement WHERE moyenDePaiementID =  ?";
        $paiement = $this->executerRequete($sql, array($paiementID));
        if ($paiement->rowCount() == 1)
            return $paiement->fetch();  
        else
            throw new Exception("Aucun moyen de paiement n'existe pour l'identifiant '. $paiementID .'");
    }
}