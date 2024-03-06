<?php

namespace db {
    use PDO;
    class DB_PDO {
        private $conn;

        private static $instace = null;

        private function __construct(array $config){
            //print_r($config);
            $this->conn = new PDO($config['dsn'], $config['user'], $config['password']);
         
        }

        public static function getInstance(array $config) {
            if(!static::$instace) {
                static::$instace = new DB_PDO($config);
            }
            return static::$instace;
        }

        public function getConnection() {
            return $this->conn;
        }

    }

}

namespace dto {
    use PDO;
    class UserDTO {
        private PDO $conn;

        public function __construct(PDO $conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $sql = 'SELECT * FROM esercizi.utenti_S5L5';
            $res = $this->conn->query($sql, PDO::FETCH_ASSOC);
    
            if($res) { // Controllo se ci sono dei dati nella variabile $res
                return $res;
            }

            return null;
        }
        public function getUserByID(int $id) {
            $sql = 'SELECT * FROM esercizi.utenti_S5L5 WHERE id = :id';
            $stm = $this->conn->prepare($sql);
            $res = $stm->execute(['id' => $id]);
    
            if($res) { // Controllo se ci sono dei dati nella variabile $res
                return $res;
            }

            return null;
        }
        public function saveUser(array $user) {
            $sql = "INSERT INTO esercizi.utenti_S5L5 (Nome, Cognome, City, Password, email) VALUES (:nome, :cognome, :citta, :password, :email)";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['nome' => $user['Nome'], 'cognome' => $user['Cognome'], 'citta' => $user['City'], 'password' => $user['Password'], 'email' => $user['email']]);
            return $stm->rowCount();
        }
        public function updateUser(array $user) {
            $sql = "UPDATE esercizi.utenti_S5L5 SET Nome = :nome, Cognome = :cognome, City = :citta, Password = :password, email = :email WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['nome' => $user['Nome'], 'cognome' => $user['Cognome'], 'citta' => $user['City'], 'password' => $user['Password'], 'email' => $user['email']]);
            return $stm->rowCount();
        }
        public function deleteUser(int $id) {
            $sql = "DELETE esercizi.utenti_S5L5 WHERE id = :id";
            $stm = $this->conn->prepare($sql);
            $stm->execute(['id' => $id]);
           return $stm->rowCount();
        }
    }
}
