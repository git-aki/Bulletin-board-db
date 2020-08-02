<?php
class Connect{
    const dbname = 'bulletin_board';
    const host = '127.0.0.1';
    const charset = 'utf8';
    const user = 'root';
    const password = 'root';
    
    private $pdo;

    function __construct($dsn = 'mysql:dbname='.Connect::dbname.';host='.Connect::host.';charset='.Connect::charset.';'
    ,$user = Connect::user,
    $password = Connect::password){
        $this->pdo = new PDO($dsn,$user,$password);
    }

    function getpdo(){
        return $this->pdo;
    }

    function pdo(){
        try {
            return $this->getpdo();
        } catch (PDOException $e) {
            echo  $e->getMessage();
            echo "<P><a href='threadIndex.php'>スレッド一覧へ戻る</a></P>";
            exit();
        }

    }

    function fetch_fun($sql_fun,$bindvalue){
        $dbh = $this->pdo();
        $sth = $dbh->prepare($sql_fun);
        $sth->bindValue(1,$bindvalue);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    function fetchall_fun($sql_fun,$bindvalue){
        $dbh = $this->pdo();
        $sth = $dbh->prepare($sql_fun);
        $sth->bindValue(1,$bindvalue);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function fetchall_fun_bind2($sql_fun,$bindvalue_1,$bindvalue_2){
        $dbh = $this->pdo();
        $sth = $dbh->prepare($sql_fun);
        $sth->bindValue(1,$bindvalue_1);
        $sth->bindValue(2,$bindvalue_2);
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    function query_fun($sql_fun){
        $dbh = $this->pdo();
        return $dbh->query($sql_fun);
    }

    function bind_1($sql_fun,$bindvalue_1){
        $dbh = $this->pdo();
        $sth = $dbh->prepare($sql_fun);
        $sth->bindValue(1,$bindvalue_1);
        $sth->execute();
    }

    function bind_2($sql_fun,$bindvalue_1,$bindvalue_2){
        $dbh = $this->pdo();
        $sth = $dbh->prepare($sql_fun);
        $sth->bindValue(1,$bindvalue_1);
        $sth->bindValue(2,$bindvalue_2);
        $sth->execute();
    }

    function bind_4($sql_fun,$bindvalue_1,$bindvalue_2,$bindvalue_3,$bindvalue_4){
        $dbh = $this->pdo();
        $sth = $dbh->prepare($sql_fun);
        $sth->bindValue(1,$bindvalue_1);
        $sth->bindValue(2,$bindvalue_2);
        $sth->bindValue(3,$bindvalue_3);
        $sth->bindValue(4,$bindvalue_4);
        $sth->execute();
    }
}
?>