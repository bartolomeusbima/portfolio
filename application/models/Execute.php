<?php

class Execute
{
    private $pdo;

    public function __construct($config)
    {
        $host    = isset($config['host']) ? $config['host'] : '';
        $dbname  = isset($config['dbname']) ? $config['dbname'] : '';
        $user    = isset($config['username']) ? $config['username'] : '';
        $pass    = isset($config['password']) ? $config['password'] : '';
        $port    = isset($config['port']) ? $config['port'] : '3306';
        $driver  = isset($config['driver']) ? $config['driver'] : 'mysql';
        $charset = isset($config['charset']) ? $config['charset'] : 'utf8mb4';

        if ($host === '' || $dbname === '' || $user === '') {
            throw new Exception('Database configuration is incomplete.');
        }

        $dsn = "$driver:host=$host;dbname=$dbname;port=$port;charset=$charset";
        $options = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        );

        $this->pdo = new PDO($dsn, $user, $pass, $options);
    }

    public function executeSelect($sql, $params = array(), $mode = 'all')
    {
        $result = array('status' => true, 'message' => '', 'data' => null);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            switch ($mode) {
                case 'all':
                    $result['data'] = $stmt->fetchAll();
                    break;
                case 'row':
                    $result['data'] = $stmt->fetch();
                    break;
                case 'one':
                    $result['data'] = $stmt->fetchColumn();
                    break;
                default:
                    $result['status'] = false;
                    $result['message'] = "Invalid fetch mode: $mode";
            }
        } catch (PDOException $e) {
            $result['status'] = false;
            $result['message'] = $e->getMessage();
        }

        return $result;
    }

    public function executeNonQuery($sql, $params = array(), $successMessage = 'Query executed successfully')
    {
        $result = array('status' => true, 'message' => $successMessage);

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        } catch (PDOException $e) {
            throw $e;
        }

        return $result;
    }
}
