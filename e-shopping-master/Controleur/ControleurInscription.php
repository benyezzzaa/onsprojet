<?php



require_once('Modele/Register.php');

class ControleurInscription implements Controleur
{
   
    private $register_code;
    
    private $register;


    
    public function __construct()
    {
        $this->register_code = 0; // default value
        $this->register = new Register();
    }

    
    public function getRegister_code()
    {
        return $this->register_code;
    }

    
    public function getRegister()
    {
        return $this->register;
    }

    public function setRegister_code($newRegister_code)
    {
        $this->login_code = $newRegister_code;
    }

    
    public function setRegister($newRegister)
    {
        $this->login_code = $newRegister;
    }


    
    public function registerUser()
    {
        
        if (empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['mail']) && empty($_POST['password']))
            $this->register_code = 0;
        elseif (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mail']) || empty($_POST['password']))
            $this->register_code = Register::FORM_INPUTS_ERROR;
        elseif (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['password']))
            $this->register_code = $this->register->createNewUser($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password']);
        $this->getHTML();
    }


    
    public function getHTML()
    {
        $vue = new Vue("Inscription");
        $vue->generer(array('register_code' => $this->register_code));
    }

}

?>