<?php


require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/UserLogin.php';

class ControleurLogin implements Controleur
{
    
    private $login_code;
  
    private $userLogin;


    public function __construct()
    {
        $this->login_code = 0;
        $this->userLogin = new UserLogin();
    }

    
    public function getLogin_code()
    {
        return $this->login_code;
    }

    
    public function getUserLogin()
    {
        return $this->userLogin;
    }

    public function setLogin_code($newLogin_code)
    {
        $this->login_code = $newLogin_code;
    }

    
    public function setUserLogin($newUserLogin)
    {
        $this->userLogin = $newUserLogin;
    }


    
    public function logOut()
    {
        if (isset($_SESSION['userID'])) {
            session_destroy();
            header('Location: index.php');
            die();
        }
    }


    
    public function logguerUser()
    {
        
        $vue = new Vue("Login");
        if (isset($_POST)) {
            if (empty($_POST['mail']) && empty($_POST['password'])) {
                $this->login_code = 0;
            } elseif (empty($_POST['mail']) || empty($_POST['password'])) {
                $this->login_code = UserLogin::FORM_INPUTS_ERROR;
            } elseif (!empty($_POST['mail']) && !empty($_POST['password'])) {
                $this->login_code = $this->userLogin->connectUser($_POST['mail'], $_POST['password']);
                if ($this->login_code == UserLogin::LOGIN_OK) {
                    header('Location: index.php?action=userProfile');
                    die();
                }
            }
        }
        $vue->generer(array('login_code' => $this->login_code));
    }


    
    public function getHTML()
    {
        
        if (isset($_SESSION['userID'])) {
            header('Location: index.php?action=userProfile');
            die();
        } 
        else {
            $this->logguerUser();
        }

    }


    public function displayUserLogin($userID)
    {
        $user = new UserLogin();
        $result = $user->getUser($userID);
        return $result;
    }

}





