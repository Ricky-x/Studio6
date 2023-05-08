<?php
class OPDBS{
    protected $conn = false;
    protected $sql;           //sql

    /**
     * construct : be responsible for connect mysql
     */
    public function __construct(){

        $host = '127.0.0.1';
        $user = 'root';
        $password = '123123';
        $dbname = 'comparison';
        $port =  '3306';

        $this->conn = mysqli_connect("$host:$port",$user,$password,$dbname) or die('mysql handle err');
    }


    /**
     * query sql
     * @access public
     * @param $sql string sql str
     * @return $result
     */
    public function query($sql){
        $this->sql = $sql;
        return mysqli_query($this->conn, $this->sql);
    }

    function insert($tableName, $column = array())
    {
        $columnName  = "";
        $columnValue = "";
        foreach ($column as $key => $value) {
            $columnName  .= $key . ",";
            $columnValue .= "'" . $value . "',";
        }
        $columnName  = substr($columnName, 0, strlen($columnName) - 1);
        $columnValue = substr($columnValue, 0, strlen($columnValue) - 1);
        $sql         = "INSERT INTO $tableName($columnName) VALUES($columnValue)";
        $this->query($sql);
    }

    /**
     * ��ȡ���еļ�¼
     * @access public
     * @param $sql ִ�е�sql���
     * @return $list �����м�¼��ɵĶ�ά����
     */
    public function getAll($sql){
        $result = $this->query($sql);
        $list = array();
        while ($row = mysqli_fetch_assoc($result)){
            $list[] = $row;
        }
        return $list;
    }

    public function getOne($sql){
        $result = $this->query($sql);
        if (!$result) {
            return false;
        }
        $list = array();
        while ($row = mysqli_fetch_assoc($result)){
            $list[] = $row;
        }
        return $list[0];
    }

    public function close() {
        $this->conn->close();
    }
}