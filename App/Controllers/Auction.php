<?php

namespace App\Controllers;

use \Core\View;
use DateTime;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Auction extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $auction = new \App\Models\Auction();

        $auctionsStatusUpdate = $auction::dateCompare();
        $auction->updateAll($auctionsStatusUpdate, 'auction');
        
        $auctionSelect = $auction->getAll();
        $stampSelect = $auction->getAll('*', 'stamp');
        $imageSelect = $auction->getAllNoDuplicate('stamp_image_id', 'image');
        $count = 0;

        for($i = 0; $i < count($auctionSelect); $i++)
        {
            if($auctionSelect[$i]['auction_status_id'] == 1)
            {
                $count++;
            }
        }

        View::renderTemplate('Auction/catalogue.php', [
                             'auctions' => $auctionSelect,
                             'stamps' => $stampSelect,
                             'images' => $imageSelect,
                             'count' => $count
        ]);
    }

    public function searchAction()
    {

        if(isset($_POST['search'])) 
        {
            $searchValue = $_POST['search'];
            $sql = "SELECT * FROM table_name WHERE column_name LIKE '%$searchValue%'";

            $auction = new \App\Models\Auction();

            $auctionsStatusUpdate = $auction::dateCompare();
            $auction->updateAll($auctionsStatusUpdate, 'auction');
            
            $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id';
            $auctionSelect = $auction->getSearch('*', 'auction', $innerjoin, 'title', 'country', $searchValue);
            $stampSelect = $auction->getAll('*', 'stamp');
            $imageSelect = $auction->getAllNoDuplicate('stamp_image_id', 'image');
            $count = 0;

            for($i = 0; $i < count($auctionSelect); $i++)
            {
                if($auctionSelect[$i]['auction_status_id'] == 1)
                {
                    $count++;
                }
            }

            View::renderTemplate('Auction/catalogue.php', [
                                'auctions' => $auctionSelect,
                                'stamps' => $stampSelect,
                                'images' => $imageSelect,
                                'count' => $count
            ]);
        }
    }

    public function sortAscAction()
    {
        $auction = new \App\Models\Auction();

        $auctionSelect = $auction->getSort('*', 'auction', ' INNER JOIN stamp ON auction.stamp_id = stamp.id ', 'title', ' ASC');
        $stampSelect = $auction->getAll('*', 'stamp');
        $imageSelect = $auction->getAllNoDuplicate('stamp_image_id', 'image');
        $count = 0;

        for($i = 0; $i < count($auctionSelect); $i++)
        {
            if($auctionSelect[$i]['auction_status_id'] == 1)
            {
                $count++;
            }
        }

        View::renderTemplate('Auction/catalogue.php', [
                            'auctions' => $auctionSelect,
                            'stamps' => $stampSelect,
                            'images' => $imageSelect,
                            'count' => $count
        ]);
    }

    public function sortDescAction()
    {
        $auction = new \App\Models\Auction();

        $auctionSelect = $auction->getSort('*', 'auction', ' INNER JOIN stamp ON auction.stamp_id = stamp.id ', 'title', ' DESC');
        $stampSelect = $auction->getAll('*', 'stamp');
        $imageSelect = $auction->getAllNoDuplicate('stamp_image_id', 'image');
        $count = 0;

        for($i = 0; $i < count($auctionSelect); $i++)
        {
            if($auctionSelect[$i]['auction_status_id'] == 1)
            {
                $count++;
            }
        }

        View::renderTemplate('Auction/catalogue.php', [
                            'auctions' => $auctionSelect,
                            'stamps' => $stampSelect,
                            'images' => $imageSelect,
                            'count' => $count
        ]);
    }

    public function showAction()
    {
        $user = new \App\Models\User();
        $id = $this->route_params['id'];

        $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id INNER JOIN image ON stamp.id = image.stamp_image_id';
        $auctionSelect = $user->getCompare('*', 'auction', 'auction.stamp_id', $id, $innerjoin);
        $auctionSelect = $auctionSelect[0];

        $auctionIdSelect = $user->getCompare('id', 'auction', 'stamp_id', $id);
        $auctionIdSelect = $auctionIdSelect[0];

        $imageSelect = $user->getCompare('*', 'image', 'stamp_image_id', $id);
        $mainImage = $imageSelect[0];

        $certificationSelect = $user->getCompare('*', '`certification`', '`id`', $auctionSelect['certification_id']);
        $certificationSelect = $certificationSelect[0];

        $conditionSelect = $user->getCompare('*', '`condition`', '`id`', $auctionSelect['condition_id']);
        $conditionSelect = $conditionSelect[0];

        View::renderTemplate('Auction/show.php',
                             ['auction' => $auctionSelect,
                              'auctionId' => $auctionIdSelect,
                              'certification' => $certificationSelect,
                              'condition' => $conditionSelect,
                              'images' => $imageSelect,
                              'mainImage' => $mainImage]);
    }

    public function bidAction()
    {
        $auction = new \App\Models\Auction();
        $user = new \App\Models\User();
        $validation = new \Core\Validation();

        $bidPrice = $user->getCompare('current_price', 'auction', 'id', $_POST['auction_id']);
        $bidPrice = $bidPrice[0]['current_price'];
        
        $bidNumber = $user->getCompare('bid_number', 'auction', 'id', $_POST['auction_id']);
        $bidNumber = $bidNumber[0]['bid_number'];

        $validation->name("mise")->value($_POST['bid'])->required()->pattern('float')->minBid($bidPrice);

        if($validation->isSuccess())
        {
            $_POST['user_id'] = $_SESSION['id'];
            $fillable = ['user_id', 'auction_id', 'auction_stamp_id', 'bid'];
            $auction->insertDb($_POST, $fillable, 'bid');
    
            $auctionData = [
                'current_price' => $_POST['bid'],
                'bid_number' => $bidNumber + 1,
                'id' => $_POST['auction_id']
            ];
    
            $fillable = ['current_price', 'bid_number', 'id'];
            $auction->update($auctionData, 'auction');
    
            View::renderTemplate('Home/index.php');
        }
        else
        {
            $errors = $validation->displayErrors();
            $id = $_POST['auction_stamp_id'];

            $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id INNER JOIN image ON stamp.id = image.stamp_image_id';
            $auctionSelect = $user->getCompare('*', 'auction', 'auction.stamp_id', $id, $innerjoin);
            $auctionSelect = $auctionSelect[0];
    
            $auctionIdSelect = $user->getCompare('id', 'auction', 'stamp_id', $id);
            $auctionIdSelect = $auctionIdSelect[0];
    
            $imageSelect = $user->getCompare('*', 'image', 'stamp_image_id', $id);
            $mainImage = $imageSelect[0];
    
            $certificationSelect = $user->getCompare('*', '`certification`', '`id`', $auctionSelect['certification_id']);
            $certificationSelect = $certificationSelect[0];
    
            $conditionSelect = $user->getCompare('*', '`condition`', '`id`', $auctionSelect['condition_id']);
            $conditionSelect = $conditionSelect[0];

            View::renderTemplate('Auction/show.php', 
                                    ['errors' => $errors,
                                    'auction' => $auctionSelect,
                                    'auctionId' => $auctionIdSelect,
                                    'certification' => $certificationSelect,
                                    'condition' => $conditionSelect,
                                    'images' => $imageSelect,
                                    'mainImage' => $mainImage]);
        }
    }

    public function userListAction()
    {
        $user = new \App\Models\User;

        $auctionsSelect = $user->getCompare('*', 'user_has_auction', 'user_id', $_SESSION['id']);
        $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id';
        $auctions = [];

        foreach($auctionsSelect as $auction)
        {
            $auctions[] = $user->getCompare('*', 'auction', 'auction.id', $auction['auction_id'], $innerjoin);
        }

        View::renderTemplate('User/auction.php', [ 'auctions' => $auctions ]);
    }

    public function createAction()
    {
        // La date de fin de l'enchère doit être au moins 3 jours après la date du jour
        $mindate = new DateTime("now + 3 days");
        $maxdate = new DateTime("now");

        View::renderTemplate('Auction/create.php', [
                             'mindate' => $mindate->format('Y-m-d'),
                             'maxdate' => $maxdate->format('Y-m-d')
        ]);
    }

    public function editAction()
    {
        $user = new \App\Models\User();
        $id = $this->route_params['id'];
        $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id';

        $auctionSelect = $user->getCompare('*', 'auction', 'auction.stamp_id', $id, $innerjoin);

        View::renderTemplate('Auction/edit.php',
                             ['auctions' => $auctionSelect]);
    }

    public function updateAction()
    {
        $auction = new \App\Models\Auction;

        $update = $auction->update($_POST, 'stamp');

        $this->userListAction();
    }

    public function storeAction()
    {
        $auction = new \App\Models\Auction();
        $validation = new \Core\Validation;
        $imageSelect = $auction->getAll('name', 'image');

        extract($_POST);
        
        $_POST['current_price'] = $floor_price;
        $_POST['date_start'] = date('Y-m-d');
        $_POST['bid_number'] = 0;
        $_POST['image_id'] = 1;
        
        // Validation des données envoyées par le formulaire
        if($_FILES['file']['error'][0] != 4)
        {
            $all_files = count($_FILES['file']['tmp_name']);
            
            for ($i = 0; $i < $all_files; $i++) {
                $validation->name("image")->value($_FILES['file']['name'][$i])->required()->pattern('file')->maxSize($_FILES['file']['size'][$i], 4097152)->ext($_FILES['file']['name'][$i])->exists($_FILES['file']['name'][$i], $imageSelect);
            }
        }
        else
        {
            $validation->fileEmpty();
        }

        $validation->name("prix de départ")->value($floor_price)->required()->pattern('float')->min(0.01);
        $validation->name("titre")->value($title)->required()->min(5)->max(80);
        $validation->name("pays")->value($country)->required()->max(45);
        $validation->name("date de fin")->value($date_end)->required()->pattern('date_ymd');
        
        if($validation->isSuccess())
        {
            $insert = $auction->insert($_POST, $_FILES);
    
            View::renderTemplate('Home/index.php');
        }
        else
        {
            $errors = $validation->displayErrors();
            View::renderTemplate('Auction/create.php', ['errors' => $errors, 'user' => $_POST]);
        }
    }
}
