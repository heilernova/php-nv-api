<?php
namespace nv\api;

use mysqli;
use mysqli_result;

require_once 'nv-database-result.php';
require_once 'nv-database-query.php';
require_once 'nv-database-init.php';
require_once 'nv-database-objet.php';

/**
 * @author Heiler Nova
 */
class Database
{
    private array $connectionData = array();
    private ?mysqli $connection = null;
    public array $errors = array();
    public int $affectedRows = 0;
    public int $insertId = 0;
    public string $sqlCommand = '';
    public ?array $sqlParamas = null;
    public DatabaseQuery $query;


    public function __construct(string $hostname = null, string $username = null, string $password = null, string $database = null)
    {
        $this->connectionData['hostname'] = $hostname ? $hostname : $_ENV['nv-settings']['database']['default']['hostname'];
        $this->connectionData['username'] = $username ? $username : $_ENV['nv-settings']['database']['default']['username'];
        $this->connectionData['password'] = $password ? $password : $_ENV['nv-settings']['database']['default']['password'];
        $this->connectionData['database'] = $database ? $database : $_ENV['nv-settings']['database']['default']['database'];
        
        $this->query = new DatabaseQuery($this);
    }

    private function openConnection()
    {
        if (!$this->connection){
            try {
                
                $data = $this->connectionData;
                $connection = mysqli_connect($data['hostname'], $data['username'], $data['password'], $data['password']);
                $this->connection = $connection;
                $this->connection->autocommit(false);
                
            } catch (\Throwable $th) {
                $messeage = [
                    'Failed to initialize connection to database',
                    'Connection data',
                    $this->connectionData
                ];

                nv_error_log($messeage, $th);
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

                    $this->affectedRows = $stmt->affected_rows;
                    $this->insertId = $stmt->insert_id;
                    $this->sql_command = $sql;
                    $this->sql_params = $params;

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
                $msg = [
                    'Error con la preparación de la base de datos.',
                    'SQL:' . $sql,
                    'Mensaje de error: ' . $this->connection->error 
                ];

                nv_error_log($msg);
            }

        } catch (\Throwable $th) {
            nv_error_log(['Error con la ejecución del metodo Database::execute'], $th);
        }
        return false;
    }


    /**
     * Ejecuta una instrución sql preparada en la base de datos
     * @param array $commnad El primero item es el sql y el segundo son los valores.
     * @return DatabaseResult
     */
    public function executeCommand(array $command):DatabaseResult
    {
        $result = $this->execute($command['sql'] ?? $command[0], $command['params'] ?? ( $command[1] ?? null));

        $res = new DatabaseResult();
        $res->result = $result;
        $res->affetedRows = $this->affectedRows;
        $res->insertId = $this->insertId;
        $res->sql_command = $this->sql_command;
        $res->sql_params = $this->sql_params;

        return new DatabaseResult($result, $this->insertId, $this->affectedRows, $command['sql'] );
    }


    /**
     * Confirma y carga los cambios en la base de datos.
     * @return bool true on success or false on failure.
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