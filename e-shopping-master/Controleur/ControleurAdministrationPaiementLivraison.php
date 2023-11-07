<?php


require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/AdministrationPaiementLivraison.php';

class ControleurAdministrationPaiementLivraison implements Controleur
{
    

    private $adminPaiementLivraison;

    private $adminPaiementLivraison_code;


    public function __construct()
    {
        $this->adminPaiementLivraison = new AdministrationPaiementLivraison();
        $this->adminPaiementLivraison_code = 0; 
    }

    public function get_AdministrationPaiementLivraison(){
     return $this->AdministrationPaiementLivraison;
    }
    public function getAdminPaiementLivraison()
    {
        return $this->adminPaiementLivraison;
    }

   
  
    public function getAdminPaiementLivraison_code()
    {
        return $this->adminPaiementLivraison_code;
    }

    
    public function setAdminPaiementLivraison($newAdminPaiementLivraison)
    {
        $this->adminPaiementLivraison = $newAdminPaiementLivraison;
    }

   
    public function setAdminPaiementLivraison_code($newAdminPaiementLivraison_code)
    {
        $this->adminPaiementLivraison_code = $newAdminPaiementLivraison_code;
    }

    
    public function handlerPaiementLivraison()
    {
        if (isset($_SESSION['userID']) && $_SESSION['niveau_accreditation'] == 1) {
            $this->addPaiementLivraison(); 
            $this->checkEditPaiement();  
            $this->removePaiementLivraison();  

            $this->getHTML();
        } else {
            header('Location: index.php?action=login');
            die();
        }
    }


    
    private function addPaiementLivraison()
    {
        if (empty($_POST['nomPaiementLivraison']) && empty($_POST['descriptionPaiementLivraison']))
            $this->adminPaiementLivraison_code = 0;
        elseif (empty($_POST['nomPaiementLivraison']) || empty($_POST['descriptionPaiementLivraison']))
            $this->adminPaiementLivraison_code = AdministrationPaiementLivraison::MISSING_PARAMETERS;
        elseif (empty($_GET['do']) && !empty($_POST['nomPaiementLivraison']) && !empty($_POST['descriptionPaiementLivraison'])) {
            $this->adminPaiementLivraison_code = $this->adminPaiementLivraison->insertPaiementLivraison($_POST['nomPaiementLivraison'], $_POST['descriptionPaiementLivraison']);
        }
    }


    
    private function checkEditPaiement()
    {
        if (!empty($_GET['do']) && !empty($_GET['paiementID'])) {
            if ($_GET['do'] == "delete")
                return;
            if ($_GET['do'] == "editPaiement") {
                $this->adminPaiementLivraison->editMoyenPaiement($_POST['nomPaiementLivraison'], $_POST['descriptionPaiementLivraison'], $_GET['paiementID']);
                $this->adminPaiementLivraison_code = AdministrationPaiementLivraison::EDIT_OK;
            }
        }
        if (!empty($_GET['paiementID']) && empty($_GET['do'])) {
            $paiement = $this->adminPaiementLivraison->getMoyensPaiementById($_GET['paiementID']);
            $vue = new Vue("AdminEditPaiement");
            $vue->generer(array(
                'paiement' => $paiement,
                'listMoyensPaiement' => $this->adminPaiementLivraison->getMoyensPaiement()));
            die();
        }
    }


   
    private function removePaiementLivraison()
    {
        if (!empty($_GET['paiementID']) && !empty($_GET['do'])) {
            if ($_GET['do'] == "delete")
                $this->adminPaiementLivraison_code == $this->adminPaiementLivraison->removePaiementLivraison($_GET['paiementID']);
        }
    }


    public function getHTML()
    {
        // TODO : vérifier que le client est connecté et qu'il a un niveau d'accrédition suffisant
        $vue = new Vue("AdministrationPaiementLivraison");
        // Par défaut, on affiche la liste des moyens de paiement & livraison
        $vue->generer(array(
            'listMoyensPaiement' => $this->adminPaiementLivraison->getMoyensPaiement(),
            'code' => $this->adminPaiementLivraison_code
        ));

    }

}

?>
