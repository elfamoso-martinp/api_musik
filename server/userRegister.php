<?php
require_once('../classes/musik_gestion.class.php');

$reponse = array();
if($_SERVER['REQUEST_METHOD']=="POST"){
    if(isset($_POST['email']) && isset($_POST['motDePasse'])){
        $locDvd = new musik_gestion();
        $result = $locDvd->addUser($_POST['email'], $_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['codePostal'], $_POST['motDePasse']);

        switch ($result) {
            case 1 : {
                header(http_response_code(200));
                $reponse['message']="Ajout ok";
                break;
            }
            case 2 :{
                header(http_response_code(400));
                $reponse['message']="Erreur, Veuillez recommencer";
                break;
            }
            case 0 :{
                header(http_response_code(409));
                $reponse['message']="L'utilisateur existe déjà !";
                break;
            }
        }
    }
}
else{
    $reponse['message']="Veuillez saisir tous les champs";
}
echo json_encode($reponse, JSON_UNESCAPED_UNICODE);
