<?php

require_once 'Controleur/Controleur.php';
require_once 'Vue/Vue.php';
require_once 'Modele/ModeleFAQ.php';

class ControleurFAQ implements Controleur
{

    
    private $question;

    public function __construct()
    {
        $this->question = new ModeleFAQ();
    }

    
    public function getQuestion()
    {
        return $this->question;
    }

    
    public function setQuestion($newQuestion)
    {
        $this->question = $newQuestion;
    }

   
    public function handlerFAQ()
    {
        $this->insertQuestion();
        $this->insertReponse();
        $this->getHTML();       
    }

   
    public function getResearch()
    {
        if (isset($_POST['research'])) {
            $research = $_POST['research'];
            $listQuestions = $this->question->getQuestions($research);
        } else {
            $listQuestions = $this->question->getAllQuestions();
        }
        return $listQuestions;
    }

    
    public function getHTML()
    {
        $vue = new Vue("FAQ");
        if (isset($_GET['question'])) {
            $listQuestions = $this->question->getQuestion($_GET['question']);
            $listReponses = $this->question->getReponses($_GET['question']);
            $vue->generer(array('listQuestions' => $listQuestions, 'listReponses' => $listReponses));
        } else {
            $listQuestions = $this->getResearch();
            $vue->generer(array('listQuestions' => $listQuestions));
        }
    }

    
    public function insertQuestion()
    {
        if (isset($_POST['sbButton2'])) {
            if (isset($_SESSION['userID'])) {
                $id = $_SESSION['userID'];
                $this->question->insertQuest($_POST['question'], $_POST['commentaires'], $id);
            } else {
                header('Location: index.php?action=login');
            }
        }
    }

   
    public function insertReponse()
    {
        if (isset($_POST['sbButton3'])) {
            if (isset($_SESSION['userID'])) {
                $id = $_SESSION['userID'];
                $this->question->insertRep($_POST['reponse'], $id, $_GET['question']);
            } else {
                header('Location: index.php?action=login');
            }
        }
    }
}
