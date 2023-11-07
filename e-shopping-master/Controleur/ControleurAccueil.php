<?php


require_once('Controleur.php');
require_once('Vue/Vue.php');

class ControleurAccueil implements Controleur
{
    
    public function __construct()
    {

    }


    public function getHTML()
    {
        $vue = new Vue("Accueil");
        $vue->generer(array());
    }
}