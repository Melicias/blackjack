<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class gameController extends BaseController
{
    public function index(){
        return View::make('base.game');
    }

    public function bet(){
        $bet_value = Post::get("bet_value");
        $userid = Session::get('userid');
        //gets the user in the database by the id
        $user = User::find($userid);
        //checks if user has any oney to bet with
        if($user->money >= $bet_value){
            $user->money -= $bet_value;
            if($user->is_valid()){
                $user->save();
                //updates the user money without the bet money
                $user->update_attributes(array('money' => $user->money));

                //remove Session last variables
                Session::remove('finalMessage');
                Session::remove('user21');

                if(Session::has('deck')){
                    $deck = Session::get('deck');
                    //if deck number of cards is lower than 2 normal decks (52*2) = 104, it creates a new deck
                    if(count($deck->cards) <= 104){
                        //creates a new deck
                        $deck = new Deck();
                    }
                }else{
                    //creates a new deck
                    $deck = new Deck();
                }
                //adds cards to the user hand and gives one card to the computer hand
                $userHand = new Hand($deck->giveCardToUser());
                $computerHand = new Hand($deck->giveCardToUser());
                $userHand->addCardToHand($deck->giveCardToUser());
                //Session
                Session::set('deck', $deck);
                Session::set('computerHand', $computerHand);
                Session::set('userHand', $userHand);
                Session::set('bet_value', $bet_value);
                //return View::make('base.game');
                Redirect::toRoute('base/play');
            } else {
                Redirect::toRoute('base/play');
            }
        }else{
            Session::remove('finalMessage');
            Session::remove('user21');
            Session::remove('userHand');
            Session::remove('computerHand');
            Redirect::toRoute('base/play');
        }
    }

    public function surrender(){
        //when surrender, user keeps half the money that he bet
        if(Session::has('bet_value')){
            $userid = Session::get('userid');
            //gets the user in the database by the id
            $user = User::find($userid);
            //updates the money
            $user->money += (Session::get('bet_value')/2);
            if($user->is_valid()){
                $user->save();
                //updates the user money in db
                $user->update_attributes(array('money' => $user->money));
                //Session
                Session::remove('computerHand');
                Session::remove('userHand');
                Session::remove('bet_value');
                Redirect::toRoute('base/play');
            }
        }else{
            Redirect::toRoute('base/play');
        }
    }

    public function stand(){
        if(Session::has('userHand')){
            //get Session variables
            $deck = Session::get('deck');
            $computerHand = Session::get('computerHand');
            //var_dump($deck);
            //gets a card from the deck and gives it to the user
            do{
                $computerHand->addCardToHand($deck->giveCardToUser());
            }while($computerHand->value<=16);
            Session::set('deck', $deck);
            Session::set('computerHand', $computerHand);
            $userHand = Session::get('userHand');
            $userid = Session::get('userid');

            if($computerHand->value == $userHand->value){
                //its a draw
                Session::set("finalMessage", "It's a DRAW");
                //give money bet to user
                //gets the user in the database by the id
                $user = User::find($userid);
                //updates the money
                $user->money += (Session::get('bet_value'));
                if($user->is_valid()){
                    $user->save();
                    //updates the user money in db
                    $user->update_attributes(array('money' => $user->money));
                }
            }else{
                //the dealer's wins
                if($computerHand->value > $userHand->value && $computerHand->value <= 21){
                    Session::set("finalMessage", "Dealer's WIN");
                    //just reset things

                }else{
                    //the user wins
                    //gives money to user * 2
                    //gets the user in the database by the id
                    $user = User::find($userid);
                    Session::set("finalMessage", $user->username . " WIN");
                    //updates the money
                    $user->money += (Session::get('bet_value')*2);
                    if($user->is_valid()){
                        $user->save();
                        //updates the user money in db
                        $user->update_attributes(array('money' => $user->money));

                        //new code for the jackpot
                        
                        gameController::addToJackpot($user,(Session::get('bet_value')*2));

                    }
                }
            }
            Session::remove('bet_value');
            Redirect::toRoute('base/play');
        }else{
            Redirect::toRoute('base/play');
        }
    }

    public function hit(){
        $deck = Session::get('deck');
        $userHand = Session::get('userHand');
        //gives another card to the user
        $userHand->addCardToHand($deck->giveCardToUser());
        //checks if user lost /if cards value is over 21, he loses
        if($userHand->value > 21){
            Session::set("finalMessage", "Dealer's WIN");
            Session::remove('bet_value');
        }
        //if user gets 21, add this session variable so it removes the buttons from the page game.phtml
        if($userHand->value == 21)
            Session::set('user21', "1");
        Redirect::toRoute('base/play');
    }

    public function double(){
        //gets the user in the database by the id
        $user = User::find(Session::get('userid'));
        $bet_value = Session::get('bet_value');
        //checks if user has any oney to bet with
        if($user->money >= $bet_value){
            $user->money -= $bet_value;
            $bet_value = $bet_value * 2;
            if($user->is_valid()){
                $user->save();
                //updates the user money without the bet money
                $user->update_attributes(array('money' => $user->money));

                $deck = Session::get('deck');
                $userHand = Session::get('userHand');
                //gives another card to the user
                $userHand->addCardToHand($deck->giveCardToUser());
                if($userHand->value > 21){
                    Session::set("finalMessage", "Dealer's WIN");
                    Session::remove('bet_value');
                    Redirect::toRoute('base/play');
                }else{
                    Session::set('bet_value',$bet_value);
                    gameController::stand();
                }
            }
        }else{
            Redirect::toRoute('base/jogar');
        }
    }

    public function addToJackpot($user,$value_won){
        //gets all the jackpots and orders them by value_won
        $jackpots = Jackpot::find('all',array('order' => 'value_won desc'));
        if(count($jackpots) == 0){
            //creates the first one, when there is no other win
            $jackpot = new Jackpot(array("value_won" => $value_won, "bj_date" => date('m/d/Y'), "username" => $user->username));
            if($jackpot->is_valid()){
                $jackpot->save();
            }
        }else{
            //checks if there is 10 jackpots
            if(count($jackpots) == 10){
                //runs all jackpots
                for($i = 0;$i<count($jackpots); $i++){
                    //checks if there is one value inferior to the one that the user just won
                    if($jackpots[$i]->value_won < $value_won){
                        //remove last element
                        $jackpots[(count($jackpots)-1)]->delete();
                        //aadd a the new jackpot to the table
                        $jackpot = new Jackpot(array("value_won" => $value_won, "bj_date" => date('m/d/Y'), "username" => $user->username));
                        if($jackpot->is_valid()){
                            $jackpot->save();
                        }
                        break;
                    }
                }
            }else{
                //just insert new line because we dont have 10 jackpots yet
                $jackpot = new Jackpot(array("value_won" => $value_won, "bj_date" => date('m/d/Y'), "username" => $user->username));
                if($jackpot->is_valid()){
                    $jackpot->save();
                }
            }
        }
    }
}