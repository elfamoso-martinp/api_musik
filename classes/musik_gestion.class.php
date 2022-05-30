<?php

require_once("connexion.class.php");

class musik_gestion
{
    private $cnx;

    public function __construct()
    {
        //comment 
		$this->cnx = connectSqlsrv();
		//$this->cnx = connectMySQL();
    }

    /*******************************************************/
    //Gestion de l'authentification et de l'enregistrement

    //Test d'existence par l'email
    public function userExist($email)
    {

        $sql = "SELECT * FROM Utilisateur WHERE mail = ?";
        $stmt = $this->cnx->prepare($sql);
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result != null;
    }

    //Méthode d'enregistrement dans la bdd
    public function addUser($email, $nom, $prenom, $adresse, $codePostal, $motDePasse){
        if ($this->userExist($email)){
            return 0;
        }
        else {
            if ($email !="" && $motDePasse !=""){
            $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
            $sql = "INSERT INTO Utilisateur (mail, nom, prenom, adresse, codePostal, motDePasse) VALUES (:email, :nom, :prenom, :adresse, :codePostal, :motDePasse)";
            $stmt = $this->cnx->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':codePostal', $codePostal);
            $stmt->bindParam(':motDePasse', $motDePasseHash, PDO::PARAM_STR);
            if($stmt->execute()){
                return 1;
            }}
            else{
                return 2;
            }
        }
    }

    //Méthode de connexion à la bdd
    public function loginUser($email, $password){
        if ($user = $this->getUserByEmail($email)){
            return password_verify($password, $user['motDePasse']);
        }
        else{
            return false;
        }
    }

    //Selection d'un utilisateur à partir de l'email
    public function getUserByEmail($email){
        $sql ="SELECT * FROM Utilisateur WHERE mail = ? ";
        $stmt = $this->cnx->prepare($sql);
        $stmt->bindParam(1,$email,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

	/**********************************************************************/
    //Gestion des dvd. Récupération de la liste des catégories
    /*********************************************************************/

    public function getCategories(){
            $sql = "select * from categories";
            $stmt = $this->cnx->prepare($sql);
            $stmt->execute();
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cnx = null;
            $stmt = null;
            return $all;//on renvoie un tableau json
    }
    /**********************************************************************/
    //Gestion des dvd. Récupération de liste de dvd d'une catégorie donnée
    /*********************************************************************/

    //Selection du contenu d'une liste à partir de l'identifiant de la catégorie associée
    public function getListe($idCat){
            $sql = "select * from videos
			inner join videoCat on videos.idVideo=videoCat.idVideo
			and videoCat.idCat = $idCat";
            $stmt = $this->cnx->prepare($sql);
            $stmt->execute();
            $all = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cnx = null;
            $stmt = null;
            return $all;//on renvoie un tableau json
    }


}


