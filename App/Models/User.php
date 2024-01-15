<?php

namespace App\Models;

use Core\View;
use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'username', 'email', 'password', 'gender', 'birthday', 'country', 'city', 'address', 'postalcode', 'privilege_id'];

    /**
     * Get all the users as an associative array
     *
     * @return array
     */
    public static function getAll($col = '*', $table = 'user')
    {
        $db = static::getDB();

        $stmt = $db->query('SELECT ' . $col . ' FROM ' . $table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getCompare($col, $table, $colValue, $value, $innerjoin = '')
    {
        $db = static::getDB();

        $sql = 'SELECT ' . $col . ' FROM ' . $table . $innerjoin . ' WHERE ' . $colValue . ' = ' . $value;

        $stmt = $db->query('SELECT ' . $col . ' FROM ' . $table . $innerjoin . ' WHERE ' . $colValue . ' = ' . $value);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUser($id)
    {
        $db = static::getDB();

        $stmt = $db->query('SELECT * FROM user WHERE id = ' . $id);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $db = static::getDB();

        $data_keys = array_fill_keys($this->fillable, '');
        $data_map = array_intersect_key($data, $data_keys);
        $nomChamp = implode(", ",array_keys($data_map));
        $valeurChamp = ":".implode(", :", array_keys($data_map));
        $sql = "INSERT INTO $this->table ($nomChamp) VALUES ($valeurChamp)";
        $stmt = $db->prepare($sql);
        
        foreach($data_map as $key=>$value)
        {
            $stmt->bindValue(":$key", $value);
        }
        
        if(!$stmt->execute())
        {
            print_r($stmt->errorInfo());
        }
    }

    public function update($data)
    {
        $db = static::getDB();
        $fields = null;

        extract($data);
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));
        $user_info = $stmt->fetch();

        if($password != $user_info['password'])
        {
            $options = [
                'cost' => 10,
            ];
            $data['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
        }
        
        foreach($data as $key=>$value)
        {
            $fields .= "$key = :$key, ";
        }

        $fields = rtrim($fields, ", ");
        $sql = "UPDATE $this->table SET $fields WHERE $this->primaryKey = :$this->primaryKey";
        $stmt = $db->prepare($sql);
        
        foreach($data as $key=>$value)
        {
            $stmt->bindValue(":$key", $value);
        }

        if(!$stmt->execute())
        {
            print_r($stmt->errorInfo());
        }
        else
        {
            return true;
        }
    }

    public function checkUser($data){
        $db = static::getDB();
        
        extract($data);
        $sql = "SELECT * FROM $this->table WHERE username = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($username));
        $count = $stmt->rowCount();

        if($count == 1)
        {
            $user_info = $stmt->fetch();
            
            if(password_verify($password, $user_info['password']))
            {
                session_regenerate_id();
                $_SESSION['id'] = $user_info['id'];
                $_SESSION['privilege_id'] = $user_info['privilege_id'];
                $_SESSION['username'] = $user_info['username'];
                $_SESSION['fingerPrint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
            }
            else
            {
               return "<ul><li>Verifier le mot de passe</li></ul>";  
            }
        }
        else
        {
            return "<ul><li>Le nom d'utilisateur n'existe pas</li></ul>";
        }
    } 
}
