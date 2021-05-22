<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $username, $password)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $this->sql = "select * from " . $table . " where username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) != 0) {
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            if ($dbusername == $username && $dbpassword == $password) {
                $login = true;
            } else {
                $login = false;
            }
        } else {
            $login = false;
        }
        return $login;
    }

    function getSesion($username)
    {
        $this->sql = "SELECT * FROM usuario WHERE username = '" . $username . "'";
        $result = mysqli_query($this->connect, $this->sql);
        
        $arrayResult = [];
        while ($fila = $result->fetch_assoc()) {
            $arrayResult[] = $fila; 
        }
        return $arrayResult;
    }

    function signUp($table, $email, $username, $password)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $email = $this->prepareData($email);
        //$password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (username, password, email) VALUES ('" . $username . "','" . $password . "','" . $email . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            return false;
        }
    }

    function SerieRegister($table, $name, $platform, $description)
    {
        $name = $this->prepareData($name);
        $platform = $this->prepareData($platform);
        $description = $this->prepareData($description);
        $this->sql =
            "INSERT INTO " . $table . " (name, platform, description) VALUES ('" . $name . "','" . $platform . "','" . $description . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            return false;
        }
    }

    function series()
    {
        $this->sql = "SELECT * FROM serie";
        $result = mysqli_query($this->connect, $this->sql);
        
        $arrayResult = [];
        while ($fila = $result->fetch_assoc()) {
            $arrayResult[] = $fila; 
        }
        return $arrayResult;
    }

    function getSeason($id)
    {
        $this->sql = "SELECT * FROM season WHERE id_serie = '" . $id . "'";
        $result = mysqli_query($this->connect, $this->sql);
        
        $arrayResult = [];
        while ($fila = $result->fetch_assoc()) {
            $arrayResult[] = $fila; 
        }
        return $arrayResult;
    }

    function addSeason($table, $name, $id_serie)
    {
        $name = $this->prepareData($name);
        $platform = $this->prepareData($platform);
        $id_serie = $this->prepareData($id_serie);
        $this->sql =
            "INSERT INTO " . $table . " (name, id_serie) VALUES ('" . $name . "','" . $id_serie . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            return false;
        }
    }

    function getChapter($id)
    {
        $this->sql = "SELECT * FROM chapter WHERE id_season = '" . $id . "'";
        $result = mysqli_query($this->connect, $this->sql);
        
        $arrayResult = [];
        while ($fila = $result->fetch_assoc()) {
            $arrayResult[] = $fila; 
        }
        return $arrayResult;
    }

    function addChapter($table,$number_chapter, $name, $id_season, $description, $date)
    {
        $number_chapter= $this->prepareData($number_chapter);
        $name = $this->prepareData($name);
        $id_season = $this->prepareData($id_season);
        $description = $this->prepareData($description);
        $date = $this->prepareData($date);
        $this->sql =
            "INSERT INTO " . $table . " (number_chapter, name, id_season, description, date) VALUES ('" . $number_chapter . "','" . $name . "','" . $id_season . "','" . $description . "','" . $date . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            return false;
        }
    }

    function addFavorite($table, $id_usuario, $id_serie)
    {
        $number_chapter= $this->prepareData($number_chapter);
        $name = $this->prepareData($name);
        $id_season = $this->prepareData($id_season);
        $description = $this->prepareData($description);
        $date = $this->prepareData($date);
        $this->sql =
            "INSERT INTO " . $table . " (id_usuario, id_serie) VALUES ('" . $id_usuario . "','" . $id_serie . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            return false;
        }
    }

    function getFavorite($id_usuario)
    {
        $this->sql = "SELECT se.* FROM (usuario us INNER JOIN user_serie uss ON us.id = uss.id_usuario) INNER JOIN serie se ON uss.id_serie = se.id WHERE us.id =" . $id_usuario . "";
        $result = mysqli_query($this->connect, $this->sql);
        
        $arrayResult = [];
        while ($fila = $result->fetch_assoc()) {
            $arrayResult[] = $fila; 
        }
        return $arrayResult;
    }

    function addComment($table, $username, $comment, $id_chapter)
    {
        $username= $this->prepareData($username);
        $comment = $this->prepareData($comment);
        $id_chapter = $this->prepareData($id_chapter);
        
        $this->sql =
            "INSERT INTO " . $table . " (username, comment, id_chapter) VALUES ('" . $username . "','" . $comment . "','" . $id_chapter . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else {
            return false;
        }
    }

    function getComment($id_chapter)
    {
        $this->sql = "SELECT * FROM chapter_comments WHERE id_chapter = '" . $id_chapter . "'";
        $result = mysqli_query($this->connect, $this->sql);
        
        $arrayResult = [];
        while ($fila = $result->fetch_assoc()) {
            $arrayResult[] = $fila; 
        }
        return $arrayResult;
    }
}

?>
