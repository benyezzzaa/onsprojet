<?php


require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/UserProfile.php';

class ControleurUserProfile implements Controleur
{
    
    private $user;
    
    private $code_update_password;


    
    public function __construct()
    {
        $this->user = new UserProfile();
        $this->code_update_password = 0; 
    }

    
    public function getUser()
    {
        return $this->user;
    }

    
    public function getCode_update_password()
    {
        return $this->code_update_password;
    }

    
    public function setUser($newUser)
    {
        $this->user = $newUser;
    }

    
    public function setCode_update_password($newCode_update_password)
    {
        $this->code_update_password = $newCode_update_password;
    }


    
    public function handlerUserProfile()
    {
        $this->changeUserPassword();
        $this->changeProfilePicture(); 
        $this->getHTML();
    }


    
    public function getHTML()
    {
        $vue = new Vue("UserProfile");

        
        if (isset($_SESSION['userID'])) {
            $userID = $_SESSION['userID'];
            $vue->generer(array(
                'listUserProfile' => $this->user->getUser($userID),
                'code' => $this->code_update_password,
            ));

        } 
        else {
            header('Location: index.php?action=login');
            die();
        }

    }


    
    public function changeProfilePicture()
    {
        
        if (!empty($_POST['submit'])) {
            $this->user->uploadPicture($_POST['submit'], $_SESSION['userID']);
        }

    }


    
    public function changeUserPassword()
    {
        if (empty($_SESSION['userID'])) // pas connecté
            return;
        if (empty($_POST['old_password']) && empty($_POST['new_password'])) {
            $this->code_update_password = 0; // par défaut
        } else if (empty($_POST['old_password']) || empty($_POST['new_password'])) {
            $this->code_update_password = UserProfile::PASSWORD_UPDATE_FORM_INVALID;
        } else if (!empty($_POST['old_password']) && !empty($_POST['new_password'])) {
            $user = $this->user->getUser($_SESSION['userID']);
            if ($user != null) {
                if ($user['mot_de_passe'] != sha1(UserLogin::SALT_REGISTER . $_POST['old_password'])) {
                    $this->code_update_password = UserProfile::PASSWORD_UPDATE_BAD_OLD_PASSWORD;
                } else {
                    $this->code_update_password = $this->user->updatePassword(sha1(UserLogin::SALT_REGISTER . $_POST['new_password']), $_SESSION['userID']);
                }
            } else
                $this->code_update_password = UserProfile::PASSWORD_UPDATE_USER_ERROR;
        }
    }
}
