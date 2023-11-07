<?php

require_once('Modele/ChiffreAffaire.php');
require_once('Modele/UserLogin.php');
require_once('Vue/Vue.php');

class ControleurChiffreAffaire implements Controleur
{

    
    private $ChiffreAffaire;


  
    public function __construct()
    {
        $this->ChiffreAffaire = new ChiffreAffaire();
    }

   
    public function getChiffreAffaire()
    {
        return $this->ChiffreAffaire;
    }

    
    public function setChiffreAffaire($newChiffreAffaire)
    {
        $this->ChiffreAffaire = $newChiffreAffaire;
    }


    
    public function getHTML()
    {
        $vue = new Vue("ChiffreAffaire");
        $vue->generer(array("CAFinal" => $this->ChiffreAffaire->getChiffreAffaire()));

    }

}