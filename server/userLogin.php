<?php

require_once '../classes/musik_gestion.class.php';

$reponse = array();

if($_SERVER['REQUEST_METHOD']=="POST") {
    if (isset($_POST['email']) && isset($_POST['motDePasse'])) {;
        $musik = new musik_gestion();
        if ($musik->loginUser($_POST['email'], $_POST['motDePasse'])) {
            $user = $musik->getUserByEmail($_POST['email']);
            header(http_response_code(200));
            $reponse['prenom'] = $user['prenom'];
        } else {
            header(http_response_code(404));
            $reponse['message'] = "email ou mot de passe invalide !";
        }
    }
    else{
            header(http_response_code(400));
            $reponse['message'] = "Certains champs ne sont pas saisis !";
        }
    }

echo json_encode($reponse, JSON_UNESCAPED_UNICODE);

