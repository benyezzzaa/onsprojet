<?php

abstract class Modele
{

    
    private $bdd;


    
    private function getBdd()
    {
        if ($this->bdd == null) {
            
            $this->bdd = new PDO('mysql:host=localhost; dbname=db_e_shopping; charset=utf8', 'rekikhazem1@gmail.com', 'ad0557319768587a736ee716b5bc48945c39aaab');
        }
        return $this->bdd;
    }


    protected function executerRequete($sql, $params = null)
    {

        if ($params == null) {
            $resultat = $this->getBdd()->query($sql); 
        } else {
            $resultat = $this->getBdd()->prepare($sql);  
            $resultat->execute($params);
        }
        return $resultat;
    }
}