<?php

namespace App\Controllers;

use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class User extends \Core\Controller
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function createAction()
    {
        View::renderTemplate('User/create.php');
    }

    public function storeAction()
    {
        $user = new \App\Models\User();
        $validation = new \Core\Validation;
        $userSelect = $user->getAll('username');
        $emailSelect = $user->getAll('email');
        extract($_POST);

        // Validation des données envoyées par le formulaire
        $validation->name("nom d'utilisateur")->value($username)->pattern('alpha')->required()->max(45)->exists($username, $userSelect);
        $validation->name('courriel')->value($email)->pattern('email')->required()->max(50)->exists($email, $emailSelect);
        $validation->name('password')->value($password)->max(20)->min(5)->required();
        
        if($validation->isSuccess())
        {
            $_POST['privilege_id'] = 3;
            $options = [
                'cost' => 10,
            ];
            $_POST['password']= password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
            
            $insert = $user->insert($_POST);
    
            View::renderTemplate('Home/index.php');
        }
        else
        {
            $errors = $validation->displayErrors();
            View::renderTemplate('User/create.php', ['errors' => $errors, 'user' => $_POST]);
        }
    }

    public function loginAction()
    {
        View::renderTemplate('User/login.php');
    }

    public function authAction()
    {
        $validation = new \Core\Validation;
        extract($_POST);
        $validation->name("nom d'utilisateur")->value($username)->pattern('alpha')->required()->max(15);
        $validation->name("mot de passe")->value($password)->max(20)->min(5)->required();
        
        if($validation->isSuccess())
        {
            $user = new \App\Models\User;
            $checkUser = $user->checkUser($_POST);

            View::renderTemplate('Home/index.php');
        }
        else
        {
            $errors = $validation->displayErrors();
            View::renderTemplate('User/login.php', ['errors' => $errors, 'user' => $_POST]);
        }
    }

    public function archiveAction()
    {
        $user = new \App\Models\User;

        $auctionsSelect = $user->getCompare('*', 'user_has_auction', 'user_id', $_SESSION['id']);
        $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id';
        $auctions = [];

        foreach($auctionsSelect as $auction)
        {
            $auctions[] = $user->getCompare('*', 'auction', 'auction.id', $auction['auction_id'], $innerjoin);
        }
        
        View::renderTemplate('User/archive.php', [ 'auctions' => $auctions ]);
    }

    public function deleteAuctionAction()
    {
        $auction = new \App\Models\Auction();

        $auction->deleteAuction(3, $_POST['id']);
    
        $this->archiveAction();
    }

    public function followAction()
    {
        $auction = new \App\Models\Auction();

        $_POST['user_id'] = $_SESSION['id'];
        $fillable = ['user_id', 'auction_id', 'auction_stamp_id'];

        $auction->insertDb($_POST, $fillable, 'watchlist');
    
        $this->watchlistAction();
    }

    //Write me a function to delete a watchlist item
    public function unfollowAction()
    {
        $auction = new \App\Models\Auction();
        
        $auction->deleteFollow('watchlist', $_POST['auction_id'], $_SESSION['id']);
    
        $this->watchlistAction();
    }

    public function watchlistAction()
    {
        $user = new \App\Models\User;

        $auctionsSelect = $user->getCompare('*', 'watchlist', 'user_id', $_SESSION['id']);
        $innerjoin = ' INNER JOIN stamp ON auction.stamp_id = stamp.id';
        $auctions = [];

        foreach($auctionsSelect as $auction)
        {
            $auctions[] = $user->getCompare('*', 'auction', 'auction.id', $auction['auction_id'], $innerjoin);
        }

        View::renderTemplate('User/watchlist.php', [ 'auctions' => $auctions ]);
    }

    public function editAction()
    {
        $user = new \App\Models\User;

        $userSelect = $user->getUser($_SESSION['id']);

        View::renderTemplate('User/edit.php',
                             ['users' => $userSelect]);
    }

    public function updateAction()
    {
        $user = new \App\Models\User;

        $update = $user->update($_POST);

        View::renderTemplate('Home/index.php');
    }
    
    public function logoutAction()
    {
        session_destroy();
        View::renderTemplate('Home/index.php');
    }
}
