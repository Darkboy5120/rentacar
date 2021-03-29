<?php
class MysqlInterface {
    private $query_char;
    public $link;
    public $result;
    public $log;
    public $charset;
    private $securitykey;
    public $response;
    public $error_code = array(
        1062 => "DUPLICATE_KEY"
    );
  
    public function getErrorName () {
        if (isset($this->error_code[$this->link->errno])) {
            return $this->error_code[$this->link->errno];
        } else {
            return "Unknow error: $this->link->errno";
        }
    }
    private function conect ($sname, $uname, $pass, $dbname) {
        $this->query_char = "?";
        $this->charset = "utf8";
        $this->securitykey = "YFD}.L*6Qfev";
        $this->response = array('code' => NULL, 'data' => NULL, 'log' => NULL);
        $this->link = new mysqli(
            $sname, $uname, $pass, $dbname
        );
        if ($this->link->connect_error) {
            throw new Exception("MysqlInterfaceError: $this->link->error");
        }
        $this->link->set_charset($this->charset);
    }
  
    private function sanitize ($par) {
        $par = $this->link->real_escape_string($par);
        return $par;
    }
  
    private function parseMetaSql ($meta_sql, $sql_par) {
        $n = count($sql_par);
        $sql = "";
        for ($i = 0; $i < strlen($meta_sql); $i++) {
            if ($meta_sql[$i] == $this->query_char && $n > 0) {
                $current_par = $sql_par[count($sql_par)-$n];
                $sql = $sql . $current_par;
                $n--;
            } else {
                $sql = $sql . $meta_sql[$i];
            }
        }
        return $sql;
    }
  
    public function __construct ($sname, $uname, $pass, $dbname) {
        $this->conect(
            $sname, $uname, $pass, $dbname
        );
    }
  
    public function query ($meta_sql) {
        $this->log = "";
        $sql_par = array();
        for ($i = 0; $i < func_num_args()-1; $i++) {
            $par = func_get_arg($i+1);
            $par = $this->sanitize($par);
            $par = "'" . $par . "'";
            array_push($sql_par, $par);
        }
        $sql = $this->parseMetaSql($meta_sql, $sql_par);
        
        $this->result = $this->link->query($sql);
        $this->log = $this->link->error;
    }
    
    public function begin ($autocommit=FALSE) {
        $this->link->autocommit($autocommit);
        $this->link->begin_transaction();
    }
    
    public function end ($action, $code, $data, $exit=TRUE) {
        if ($action === "commit") {
            $this->commit();
        } else if ($action === "rollback") {
            $this->rollback();
        }
        $this->abort($code, $data, $exit);
    }
    
    public function abort ($code, $data, $exit=TRUE) {
        $this->response['log'] = $this->log;
        $this->response['code'] = $code;
        $this->response['data'] = $data;
        echo json_encode($this->response);
        $this->close($exit);
    }
    
    public function rollback () {
        return $this->link->rollback();
    }
    
    public function commit () {
        return $this->link->commit();
    }
  
    public function close ($e=FALSE) {
        $this->link->close();
        if ($e === TRUE) {
            exit;
        }
    } 
    
    public function getSecuritykey() {
        return $this->securitykey;
    }
}

/*
SAMPLE USE

$mi0 = new MysqlInterface(
	'localhost',
	'root',
	'',
	'test'
	);

$user_id = '1';

if (!isset($_GET['securitykey'])
    ) {
    $mi0->abort(-1, NULL);
} else if ($_GET['securitykey'] !== $mi0->getSecuritykey()) {
    $mi0->abort(-2, NULL);
}

$mi0->begin();

$mi0->query('
    SELECT id_estado, nombre
    FROM estados'
);
if ($mi0->result->num_rows > 0) {
    $data = $mi0->result->fetch_all(MYSQLI_ASSOC);
    $mi0->end('commit', 0, $data );
} else {
    $mi0->end('rollback', -3, NULL);
}

*/
