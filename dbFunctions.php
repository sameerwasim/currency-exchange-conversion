<?php

/**
 * Database Connection
 */
class Database
{

  private $host;
  private $username;
  private $password;
  public $conn;

  function __construct($host, $username, $password) {
    $this->host = $host;
    $this->username = $username;
    $this->password = $password;
    // Create Connection
    $this->conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
  }

  /* Use Database -
    Checks if database with that name exists or not,
    if not than it creates one and uses it.
  */
  public function useDB($dbName) {
    $sql = "USE $dbName";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
  }

  /* Insert to Table -
    Insert the values with columns name to the
    specified table and also make sure all values
    are safe before inserting.
  */
  public function insertTbl($table, $columns, $values) {
    $sql = "INSERT INTO `$table` (`".implode('`, `', $columns)."`)
            VALUES (:".implode(', :', $columns).")";
    $sql = $this->conn->prepare($sql);
    foreach ($columns as $key => $value) {
      $sql->bindParam(":$columns[$key]", $values[$key]);
    }
    if ($sql->execute()) {
      return $this->conn->lastInsertId();
    } else {
      return $sql->errorinfo();
    }
  }

  /* Update to Table -
    Update the values with columns name to the
    specified table and also make sure all values
    are safe before updating.
  */
  public function update($table, $values, $where) {
    foreach ($values as $key => $value)
      $columns[] = "`$key` = '$value'";
    $sql = "UPDATE `$table` SET ".implode(', ', $columns)." WHERE ".$where."";
    $sql = $this->conn->prepare($sql);
    if ($sql->execute()) {
      return true;
    } else {
      return $sql->errorinfo();
    }
  }

  /* Select with condition -
    selects all values from these
    specified columns from the specified
    table where your conditions satisfies.
  */
  public function select($data) {
    $sql = "SELECT ";
    $sql .= empty($data['columns']) ? '* ' : "$data[columns] ";
    $sql .= "FROM `$data[table]` ";
    $sql .= empty($data['join']) ? '' : "$data[join] ";
    $sql .= empty($data['where']) ? '' : "WHERE $data[where] ";
    $sql .= empty($data['limit']) ? '' : "LIMIT $data[limit] ";
    $sql = $this->conn->prepare($sql);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  /* Custom Query -
    Run an entirely custom query
  */
  public function custom($query) {
    $sql = $this->conn->prepare($query);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
  }

  /* Upload File -
    Upload the file to the server
    (File, File New Name, Folder Name)
  */
  public function uploadFile($file, $name, $folder) {
    $type = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $target_file = strtolower("../images/$folder/".str_replace(' ', '-', $name)."-".date('Ymd').".$type");
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
      return strtolower("images/$folder/".str_replace(' ', '-', $name)."-".date('Ymd').".$type");
    } else {
      return strtolower("images/$folder/".str_replace(' ', '-', $name)."-".date('Ymd').".$type");
    }
  }

  /* Generate String -
    Used to Generate a random ass string 
    according to user length.
  */
  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }


  /* Get Client ip -
    Used to get the client ip.
  */
  function getClientIp() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }

}

$database = new Database(dbHOST, dbUSERNAME, dbPASSWORD);
$database->useDB(database); # Specify what database to use here.

?>