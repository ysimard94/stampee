<?php

namespace App\Models;

use Core\View;
use PDO;

/**
 * Example user model
 *
 * PHP version 7.0
 */
class Auction extends \Core\Model
{
    protected $primaryKey = 'id';
    
    protected $tableAuction = 'auction';
    protected $fillableAuction = ['date_start', 'date_end', 'floor_price', 'current_price', 'bid_number', 'stamp_id', 'auction_status_id'];

    protected $tableStamp = 'stamp';
    protected $fillableStamp = ['title', 'country', 'creation_date', 'colors', 'dimensions', 'condition_id', 'certification_id'];

    protected $tableImage = 'image';
    protected $fillableImage = ['stamp_image_id', 'name', 'path'];

    protected $tableUserAuction = 'user_has_auction';
    protected $fillableUserAuction = ['user_id', 'auction_id', 'auction_stamp_id'];


    public static function getAll($col = '*', $table = 'auction')
    {
        $db = static::getDB();

        $stmt = $db->query('SELECT ' . $col . ' FROM ' . $table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSearch($col = '*', $table = 'auction', $innerjoin = '', $col1 = '', $col2 = '', $search = '')
    {
        $db = static::getDB();

        $stmt = $db->query('SELECT ' . $col . ' FROM ' . $table . $innerjoin . ' WHERE '. $col1 .' LIKE "%' . $search . '%" OR ' . $col2 . ' LIKE "%' . $search . '%"');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getSort($col = '', $table = '', $innerjoin = '', $value = '', $order = '')
    {
        $db = static::getDB();

        $stmt = $db->query('SELECT ' . $col . ' FROM ' . $table . $innerjoin . ' ORDER BY '. $value . $order);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Requête prise de https://stackoverflow.com/questions/1785634/select-distinct-on-one-column-return-multiple-other-columns-sql-server
    public static function getAllNoDuplicate($col = '', $table = '')
    {
        $db = static::getDB();

        $stmt = $db->query('WITH DEDUPE AS (
            SELECT  *
                  , ROW_NUMBER() OVER ( PARTITION BY ' . $col . ' ORDER BY ' . $col . ') AS OCCURENCE
            FROM ' . $table . '
            )
        SELECT * FROM DEDUPE
        WHERE
        OCCURENCE = 1 ');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data, $file)
    {
        $db = static::getDB();
     
        $target_dir = dirname(__DIR__, 2) . '/public/assets/stamps_img/';
        $all_files = count($file['file']['tmp_name']);

        $this->insertDb($data, $this->fillableStamp, $this->tableStamp);

        $stampId = $this->getLastId();
        $data['stamp_id'] = $stampId[0]['LAST_INSERT_ID()'];
        
        for ($i = 0; $i < $all_files; $i++) {
            $target_file = $target_dir . basename($file["file"]["name"][$i]);

            $dataImage = [
                'stamp_image_id' => $stampId[0]['LAST_INSERT_ID()'],
                'name' => $file["file"]["name"][$i],
                'path' => $target_file
            ];

            $this->uploadImage($file, $target_file, $i);

            $this->insertDb($dataImage, $this->fillableImage, $this->tableImage);
        }
        
        $data['auction_status_id'] = 1;

        $this->insertDb($data, $this->fillableAuction, $this->tableAuction);
        
        $auctionId = $this->getLastId();
        
        $dataUserAuction = [
            'user_id' => $_SESSION['id'],
            'auction_id' => $auctionId[0]['LAST_INSERT_ID()'],
            'auction_stamp_id' => $stampId[0]['LAST_INSERT_ID()']
        ];

        $this->insertDb($dataUserAuction, $this->fillableUserAuction, $this->tableUserAuction);
    }

    public function insertDb($data, $fillable, $table)
    {
        $db = static::getDB();

        $data_keys = array_fill_keys($fillable, '');
        $data_map = array_intersect_key($data, $data_keys);
        $nomChamp = implode(", ",array_keys($data_map));
        $valeurChamp = ":".implode(", :", array_keys($data_map));
        $sql = "INSERT INTO $table ($nomChamp) VALUES ($valeurChamp)";
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

    public function deleteFollow($table, $value1, $value2)
    {
        $db = static::getDB();

        $query = "DELETE FROM $table WHERE auction_id = :auction_id AND user_id = :user_id";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":auction_id", $value1);
        $stmt->bindParam(":user_id", $value2);
        
        $stmt->execute();
    }

    public function deleteAuction($value1, $value2)
    {
        $db = static::getDB();

        $query = "UPDATE auction SET auction_status_id = :auction_status_id WHERE stamp_id = :stamp_id";
        $stmt = $db->prepare($query);

        $stmt->bindParam(":auction_status_id", $value1);
        $stmt->bindParam(":stamp_id", $value2);

        $stmt->execute();
    }

    public function update($data, $table)
    {
        $db = static::getDB();
        $fields = null;
        
        extract($data);

        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($id));

        foreach($data as $key=>$value)
        {
            $fields .= "$key = :$key, ";
        }

        $fields = rtrim($fields, ", ");
        $sql = "UPDATE $table SET $fields WHERE $this->primaryKey = :$this->primaryKey";
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

    public function updateAll($data, $table)
    {
        $db = static::getDB();
        $fields = null;

        for($i = 0; $i < count($data); $i++)
        {
            extract($data[$i]);
            
            $sql = "SELECT * FROM $table WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($id));

            foreach($data[$i] as $key=>$value)
            {
                $fields .= "$key = :$key, ";
            }

            $fields = rtrim($fields, ", ");
            $sql = "UPDATE $table SET $fields WHERE $this->primaryKey = :$this->primaryKey";
            $stmt = $db->prepare($sql);
            
            foreach($data[$i] as $key=>$value)
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
    }

    public function uploadImage($file, $target_file, $i)
    {
        if (move_uploaded_file($file["file"]["tmp_name"][$i], $target_file)) 
        {
            echo "Le fichier ". htmlspecialchars( basename( $file["file"]["name"][$i])). " a été téléchargé avec succès.";
        }
        else
        {
            echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
        }
    }

    public static function getLastId()
    {
        $db = static::getDB();
        
        $stmt = $db->query('SELECT LAST_INSERT_ID()');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function dateCompare()
    {
        $db = static::getDB();

        $auctions = static::getAll();
        $now = date('Y-m-d');
        
        for($i = 0; $i < count($auctions); $i++)
        {
            if($auctions[$i]['date_end'] <= $now)
            {
                $auctions[$i]['auction_status_id'] = 2;
            }
            else
            {
                $auctions[$i]['auction_status_id'] = 1;
            }
        }

        return $auctions;
    }
}