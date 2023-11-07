<?php


require_once('Controleur/Controleur.php');
require_once('Vue/Vue.php');

class ControleurErreur implements Controleur
{
    
    public function __construct()
    {

    }

   
    public function getHTML()
    {
        $vue = new Vue("Erreur");
        $vue->generer(array());
    }
}