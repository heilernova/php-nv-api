<?php
namespace nv\database;

use mysqli;
use mysqli_result;

use function nv\api\nv_api_error_log;
use function nv\api\response;

/**
 * En esta clase el auto commit esta desactivado.
 * @author Heiler Nova.
 */
class Database
{

    private array $connectionData = array();

    private ?mysqli $connection = null;

    public array $errors = array();

    public int $affectedRows = 0;
    public int $insertId = 0;

    /**
     * Inicializa la clase de conexión la base de datos mysqli 
     */
    public function __construct(string $hostname = null, string $username = null, string $password = null, string $database = null)
    {
        $this->connectionData['hostname'] = $hostname ? $hostname : NV_API_DB_HOSTNAME;
        $this->connectionData['username'] = $username ? $username : NV_API_DB_USERNAME;
        $this->connectionData['password'] = $password ? $password : NV_API_DB_PASSWORD;
        $this->connectionData['database'] = $database ? $database : NV_API_DB_DATABASE;
    }

    /**
     * Abre una conexión en la base de datos en coso de que no este iniciada.
     */
    private function openConnection()
    {
        if (!$this->connection){
            extract($this->connectionData);
            $conection = @mysqli_connect($hostname, $username, $password, $database);
            
            // response($conection);
            if (!$conection){
                $msg = [
                    "Error con la conexión de la base de datos.",
                    "Datos de conexión",
                    "\tServidor:        $hostname",
                    "\tUsuario:         $username",
                    "\tPassword:        $password",
                    "\tBase de datos    $database",
                    "Mensaje de errror",
                    mysqli_connect_error()
                ];

                nv_api_error_log($msg);

            }else{
                $this->connection = $conection;
                $this->connection->autocommit(false);
            }
        }
    }


    /**
     * Ejecuta una instrución sql preparada en la base de datos
     * @param string $sql Instrución sql a ejecutar en caso de usar parametros de debe espeficiar con "?"
     * @param array $params Array de los parametros de la consulta slq. el parametro es opcional,
     * en caso de que la cosulta sql no tenga parametros por ingresar.
     * @return mysqli_result|bool
     */
    public function execute(string $sql, ?array $params = null):mysqli_result|bool
    {
        try {
            $this->openConnection();
            $stmt = $this->connection->prepare($sql);

            if ($stmt){
                
                if ($params){
                    call_user_func_array(array($stmt, 'bind_param'), $this->getRefValues($params));
                }

                if ($stmt->execute()){

                    // Guardamos el número de filas afectadas de la cosulta sql
                    $this->affectedRows = $stmt->affected_rows;

                    // Guardamos el id generado de la consulta sql.
                    $this->insertId = $stmt->insert_id;

                    $result = $stmt->get_result();

                    return $result ? $result : true;
                }else{

                    $this->errors[] = [
                        'slq'=>$sql,
                        'mensaje'=>$stmt->error
                    ];

                    return false;
                }

            }else{
                nv_api_error_log([
                    'Error con la preparación de la consulta sql.',
                    'SQL: ' . $sql,
                    'Mensajse: ' . $this->connection->error
                ]);
            }

        } catch (\Throwable $th) {
            nv_api_error_log(
                ['Error al ejecutar en commando sql en la base de datos', $th]
            );
        }
        return false;
    }


    /**
     * Ejecuta una instrución sql preparada en la base de datos
     * @param array $commnad El primero item es el sql y el segundo son los parametros.
     * @return DatabaseResult
     */
    public function executeCommand(array $command):DatabaseResult
    {
        $result = $this->execute($command['sql'] ?? $command[0], $command['params'] ?? ( $command[1] ?? null));
        return new DatabaseResult($result, $this->insertId, $this->affectedRows);
    }


    /**
     * Confirma y carga los cambios en la base de datos.
     */
    public function commit():bool
    {
        $result = false;
        $result = $this->connection?->commit();
        $this->connection?->close();
        return $result;
    }

    private function getRefValues(array $params):array
    {
        $ref = array(''); // Creamos un array con un valor vacio
        
        foreach($params as $key=>$value){
            $ref[0] .= is_string($value) ? 's' : (is_int($value) ? 'i' : 'd');
            $ref[] = &$params[$key];
        }

        return $ref;
    }
}