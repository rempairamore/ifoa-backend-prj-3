<?php

/* namespace db {
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

} */

namespace dto {
    use PDO;
    class UserDTO {
        private PDO $conn;

        public function __construct(PDO $conn) {
            $this->conn = $conn;
        }

        public function getAll() {
            $sql = 'SELECT * FROM esercizi.utenti_S5L5';
            // Esecuzione della query senza specificare la modalità di fetch qui
            $stmt = $this->conn->query($sql);
        
            if($stmt) { // Controllo se lo statement è valido
                // Imposta la modalità di fetch per ottenere un array associativo
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($res) { // Controllo se ci sono dei dati
                    return $res;
                }
            }
        
            return "ciao hai sbagliato o non c'è niente";
        }
        public function getUserByEmail(string $email) {
            $sql = "SELECT * FROM esercizi.utenti_S5L5 WHERE email = :email";
            try {
                $stm = $this->conn->prepare($sql);
                $stm->execute(['email' => $email]);
                return $stm->fetch(PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                // Log dell'errore o visualizzazione per debugging
                echo "Errore durante il salvataggio dell'utente: " . $e->getMessage();
                return 0; // Indica un fallimento
            }
        }
        public function saveUser(array $user) {
            $sql = "INSERT INTO esercizi.utenti_S5L5 (Nome, Cognome, City, Password, email) VALUES (:nome, :cognome, :citta, :password, :email)";
            try {
                $stm = $this->conn->prepare($sql);
                $stm->execute(['nome' => $user['Nome'], 'cognome' => $user['Cognome'], 'citta' => $user['City'], 'password' => $user['Password'], 'email' => $user['email']]);
                return $stm->rowCount();
            } catch (\PDOException $e) {
                // Log dell'errore o visualizzazione per debugging
                echo "Errore durante il salvataggio dell'utente: " . $e->getMessage();
                return 0; // Indica un fallimento
            }
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