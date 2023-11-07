<?php


require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/AdministrationHistoriqueCommande.php';

class ControleurAdministrationHistoriqueCommande implements Controleur
{
    /**
     * @var historiqueCommande
     */
    private $historiqueCommande;


    public function __construct()
    {
        $this->historiqueCommande = new AdministrationHistoriqueCommande();
    }

    
    public function getHistoriqueCommande()
    {
        return $this->historiqueCommande;
    }

   
    public function setHistoriqueCommande($newHistoriqueCommande)
    {
        $this->historiqueCommande = $newHistoriqueCommande;
    }


    
    public function handlerHistoriqueCommande()
    {
        $this->checkEditCommande();

        $this->getHTML();

    }


   
    public function checkEditCommande()
    {
        if ((!empty($_GET['do'])) && (!empty($_GET['panierID']))) {
            if ($_GET['do'] == 'paid') {
                $this->historiqueCommande->turnPaid($_GET['panierID']);
            } else {
                if ($_GET['do'] == 'notPaid') {
                    $this->historiqueCommande->turnNotPaid($_GET['panierID']);
                }
            }
        }
    }


    
    public function getHTML()
    {
        $vue = new Vue("AdministrationHistoriqueCommande");
        if (!empty($_POST['Name'])) {
            $allPanier = $this->historiqueCommande->getPanierUser($_POST['Name']);

        } else {
            if (!empty($_POST['PanierID'])) {
                $allPanier = $this->historiqueCommande->getPanier($_POST['PanierID']);
            } else {
                $allPanier = $this->historiqueCommande->getAllPanier();
            }
        }

        $lstCommande = [];

        foreach ($allPanier as $element) {
            $lstCommande[$element['panierID']] = $this->historiqueCommande->getCommande($element['panierID']);

        }
        if (!empty($_POST['Name'])) {
            $allPanier = $this->historiqueCommande->getPanierUser($_POST['Name']);

        } else {
            if (!empty($_POST['PanierID'])) {

                $allPanier = $this->historiqueCommande->getPanier($_POST['PanierID']);
            } else {
                $allPanier = $this->historiqueCommande->getAllPanier();
            }
        }


        $vue->generer(array('listPanier' => $allPanier, 'lstCommande' => $lstCommande));


    }

}
