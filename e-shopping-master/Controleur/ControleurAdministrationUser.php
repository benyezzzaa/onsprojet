<?php


require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/AdministrationUser.php';

class ControleurAdministrationUser implements Controleur
{

    
    private $user;


    
    public function __construct()
    {
        $this->user = new AdministrationUser();
    }

    
   
    public function getUser()
    {
        return $this->user;
    }

    
    public function setUser($newUser)
    {
        $this->user = $newUser;
    }


    
    public function handlerAdministrationUser()
    {
        if (isset($_SESSION['userID']) && $_SESSION['niveau_accreditation'] == 1) {
            $this->deleteUser();    
            $this->changeAccre();   
            $this->getHTML();       
        } else {
            header('Location: index.php?action=login');
            die();
        }
    }


    
    public function displayUser($userID)
    {
        $user = new AdministrationUser();
        $result = $user->getUser($userID);
        return $result;
    }


    
    public function getHTML()
    {
        $vue = new Vue("AdministrationUser");
        $listUsers = $this->user->getUserList();
        $vue->generer(array('listUsers' => $listUsers));

    }


    
    public function deleteUser()
    {
        if (isset($_GET['do']) && (isset($_GET['userID']))) {
            if ($_GET['do'] == "deleteUser") {
                if ($_SESSION['userID'] != $_GET['userID']) {
                    $this->user->deleteUser($_GET["userID"]);
                } else {
                    throw new Exception("Impossible de supprimer le compte sur lequel vous êtes connecté actuellement");
                }
            }
        }
    }


    
    public function changeAccre()
    {
        if (isset($_GET['do']) && (isset($_GET['userID'])) && (isset($_GET['accLevel']))) {
            if ($_GET['do'] == "changeAcc") {
                
                $this->user->updateUserStatus($_GET["userID"], $_GET["accLevel"]);
               }
            }
        }
    }





?>

<script type="text/javascript">
 
    function changeAccreditation(value, id) {
        window.location = "?action=adminUser&do=changeAcc&userID=" + id + "&accLevel=" + value;
    }
</script>