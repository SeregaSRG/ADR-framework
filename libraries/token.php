<?php
class Token {
    static function generate() {
        return hash('sha512', uniqid(rand(), true));
    }

    static function insert($id, $token, $ip) {
        global $pdo;
        
        $QueryById = $pdo->prepare("UPDATE tokens SET `closed`='1' WHERE `user_id`= :id");
        $QueryById->execute([
            ':id' => $id
        ]);
         
        $insertToken = $pdo->prepare("INSERT INTO `tokens` (`user_id`,`token`,`user_ip`) VALUES (:id, :token,:ip)");
        $insertToken->execute([
            ':id' => $id,
            ':token' => $token,
            ':ip' => $ip
        ]);
    }
    
    static function getId ($token){
        global $mysqli;
        $QueryByToken = $mysqli->query("SELECT * FROM `tokens` WHERE token='".htmlspecialchars($token, ENT_QUOTES)."' AND closed='0'");
        if(!$QueryByToken -> num_rows){
            Response::error('-1');
            exit();
        }
        $byTokenObj = $QueryByToken->fetch_object();
        return $byTokenObj->user_id;
    }
    
    static function isClosed($token) {
        global $mysqli;
        $QueryByToken = $mysqli->query("SELECT * FROM `tokens` WHERE token='".htmlspecialchars($token, ENT_QUOTES)."'");
        if(!$QueryByToken -> num_rows){
            Response::error('-1');
            exit();
        }
        $byTokenObj = $QueryByToken->fetch_object();
        return $byTokenObj->closed;
    }
}