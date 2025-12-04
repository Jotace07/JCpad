<?php

class Database {
    private static $host = 'localhost';
    private static $database = 'jc_company';
    private static $username = 'jc_database';
    private static $password = 'jc';

    private static $admin_user = 'root';
    private static $admin_pass = '<change_with_your_root_password>';

    // ... (restante da classe)

    /**
     * @return PDO|null Conecta-se ao banco de dados 'jc_company' usando o usuário 'jc_database'.
     */
    public static function connect() {
        $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$database . ";charset=utf8mb4";
        // Opções PDO...
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, self::$username, self::$password, $options);
            return $pdo;
        }
        catch (\PDOException $e){
            echo "Error while connecting to the database: " . $e->getMessage();
            return null;
        }
    }

    /**
     * @return PDO|null Conecta-se como root para criar o DB e o usuário.
     */
    private static function connect_admin() {
        $dsn = "mysql:host=" . self::$host . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, self::$admin_user, self::$admin_pass, $options);
            return $pdo;
        }
        catch (\PDOException $e){
            echo "Error while connecting as ADMIN: " . $e->getMessage();
            return null;
        }
    }


    public static function create_tables(){
        
        $admin = 'admin';
        $guest = 'user';
        $email_admin = 'admin@admin.com';
        $email_guest = 'user@user.com';

        $create_jc_company_db = "CREATE DATABASE IF NOT EXISTS " . self::$database . ";";
        $create_jc_databse_user = "CREATE USER IF NOT EXISTS '" . self::$username . "'@'" . self::$host . "' IDENTIFIED BY '" . self::$password . "';";
        $grant_privileges = "GRANT ALL PRIVILEGES ON " . self::$database . ".* TO '" . self::$username . "'@'" . self::$host . "';";
        $flush_privileges = "FLUSH PRIVILEGES;"; 

        try {
            $pdo_admin = self::connect_admin(); 
            
            if ($pdo_admin) {
                $pdo_admin->exec($create_jc_company_db);
                $pdo_admin->exec($create_jc_databse_user);
                $pdo_admin->exec($grant_privileges);
                $pdo_admin->exec($flush_privileges);
                echo "Database and user were created!";
            } else {
                echo "Failed to connect as admin, cannot create DB/User.";
                return;
            }
        }
        catch (\PDOException $e){
            echo "Error creating database or user: " . $e->getMessage();
            return;
        }

        $create_table_users = "CREATE TABLE IF NOT EXISTS users (
            id INT NOT NULL AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(32) NULL,
            PRIMARY KEY (id))";

        $create_table_notes = "CREATE TABLE IF NOT EXISTS notes (
            id INT NOT NULL AUTO_INCREMENT,
            username VARCHAR(255) NOT NULL,
            title VARCHAR(64) NOT NULL,
            note TEXT NOT NULL,
            PRIMARY KEY (id));";
        
        try {
            $pdo = self::connect();
            
            if ($pdo) {
                $pdo->exec($create_table_users);
                echo "Table users was created!";
                
                $pdo->exec($create_table_notes);
                echo "Table notes was created!";
            } else {
                echo "Failed to connect to jc_company, cannot create tables.";
                return;
            }
        }
        catch (\PDOException $e){
            echo "Error creating table: " . $e->getMessage();
            return;
        }
        
        $bcryptInAdmin = password_hash($admin, PASSWORD_BCRYPT);
        $create_admin = $pdo->prepare("INSERT INTO users (email, username, password, role) VALUES (:email, :username, :password, 'admin')");
        $create_admin->bindParam(':email', $email_admin);
        $create_admin->bindParam(':username', $admin);
        $create_admin->bindParam(':password', $bcryptInAdmin);

        try {
            $create_admin->execute();
            echo 'Admin user was created!';
        }
        catch (\PDOException $e){
            // Usei 'echo' aqui, pois a linha no seu código original estava faltando.
            echo "Error creating admin user: " . $e->getMessage(); 
        }
        
        $bcryptInGuest = password_hash($guest, PASSWORD_BCRYPT);
        $create_Guest = $pdo->prepare("INSERT INTO users (email, username, password, role) VALUES (:email, :username, :password, 'user')");
        $create_Guest->bindParam(':email', $email_guest);
        $create_Guest->bindParam(':username', $guest);
        $create_Guest->bindParam(':password', $bcryptInGuest);

        try {
            $create_Guest->execute();
            echo 'Guest user was created!';
        }
        catch (\PDOException $e){
            echo "Error creating guest user: " . $e->getMessage();
        }
    }

}

// Uncomment the line below and type "php ./Models/Database.php" in your terminal if you want to create the database and tables used in JCpad!
// Database::create_tables();