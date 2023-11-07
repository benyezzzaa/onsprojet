<?php


require_once('Controleur.php');
require_once('Vue/Vue.php');

class ControleurTunnel implements Controleur
{
    
    public function __construct()
    {

    }


   
    public function getHTML()
    {
        $vue = new Vue("Tunnel");
        $vue->generer(array());
    }
}