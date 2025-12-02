<?php    

class Database {
    private static $host = 'localhost';
    private static $database = 'jc_company';
    private static $username = 'jc_database';
    private static $password = 'jc';

    /**
    *@return PDO|null 'retornar null em caso de falha'.
    */

    public static function connect() {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$database . ";charset=utf8mb4";

        $options = [
            // Garante que o PDO lança exceções em caso de erros
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            // Define o modo de retorno padrão como array associativo
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Desativa a preparação de comandos (emulações) para segurança
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, self::$username, self::$password, $options);
            return $pdo;
        }
        catch (\PDOException $e){
            echo "Error while connecting in mysql: " . $e->getMessage();
            return null;
        }

    }

    public function create_table(){

        $admin = 'admin';
        $guest = 'guest';
        $email_admin = 'admin@email.com';
        $email_guest = 'guest@email.com';

        $create_table_users = "create table if not exists users (
id INT NOT NULL AUTO_INCREMENT,
email VARCHAR(32) NOT NULL,
username VARCHAR(32) NOT NULL,
password VARCHAR(32) NOT NULL,
role VARCHAR(32) NULL,
PRIMARY KEY (id));";

        try {
            $pdo = self::connect();
            $pdo->exec($create_table_users);
            echo "Table users was created!";
        }
        catch (\PDOException $e){
            echo "Error creating table: " . $e->getMessage();
        }

        $bcryptInAdmin = password_hash($admin, PASSWORD_BCRYPT);
        $create_admin = $pdo->prepare("INSERT INTO users (username, password) VALUES (:email, :username, :password)");
        $create_admin->bindParam(':email', $email_admin);
        $create_admin->bindParam(':username',  $admin);
        $create_admin->bindParam(':password', $bcryptInAdmin);

        try {
            $create_admin->execute();
            echo 'Admin user was created!';
        }
        catch (\PDOException $e){
            "Error: " . $e->getMessage();
        }
        
        $bcryptInGuest = password_hash($guest, PASSWORD_BCRYPT);
        $create_Guest = $pdo->prepare("INSERT INTO users (email, username, password) VALUES (:email, :username, :password)");
        $create_Guest->bindParam(':email', $email_guest);
        $create_Guest->bindParam(':username', $guest);
        $create_Guest->bindParam(':password', $bcryptInGuest);

        try {
            $create_Guest->execute();
            echo 'Guest user was created!';
        }
        catch (\PDOException $e){
            "Error: " . $e->getMessage();
        }
    }

}
