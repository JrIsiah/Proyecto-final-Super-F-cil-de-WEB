<?php
class Database
{
    private $pdo;

    public function __construct($db_file)
    {
        try {
            // Intentar conectar a la base de datos SQLite
            $this->pdo = new PDO("sqlite:$db_file");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear tablas si no existen
            $this->createTables();
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    private function createTables()
    {
        $sql = "
        CREATE TABLE IF NOT EXISTS clientes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            matricula TEXT NOT NULL,
            nombre TEXT NOT NULL
        );

        CREATE TABLE IF NOT EXISTS articulos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nombre TEXT NOT NULL,
            precio REAL NOT NULL
        );

        CREATE TABLE IF NOT EXISTS facturas (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            fecha TEXT NOT NULL,
            codigo_cliente TEXT NOT NULL,
            nombre_cliente TEXT NOT NULL,
            total REAL NOT NULL,
            comentario TEXT
        );

        CREATE TABLE IF NOT EXISTS detalle_factura (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            factura_id INTEGER NOT NULL,
            articulo TEXT NOT NULL,
            cantidad INTEGER NOT NULL,
            precio REAL NOT NULL,
            total REAL NOT NULL,
            FOREIGN KEY (factura_id) REFERENCES facturas (id)
        );
        ";

        try {
            $this->pdo->exec($sql);
        } catch (PDOException $e) {
            die("Error al crear tablas: " . $e->getMessage());
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }
}

// Verificar si el archivo se está accediendo mediante una solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ruta al archivo de base de datos
    $db_file = __DIR__ . '/db/DBfacturacion.sqlite';

    // Crear instancia de la base de datos
    $db = new Database($db_file);

    //echo "Base de datos y tablas creadas exitosamente.";
} else {
    // Si no es una solicitud POST, no hacer nada
}
