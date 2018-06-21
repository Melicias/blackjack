<?php
use ArmoredCore\Controllers\BaseController;
use ArmoredCore\WebObjects\Redirect;
use ArmoredCore\WebObjects\Session;
use ArmoredCore\WebObjects\View;
use ArmoredCore\WebObjects\Post;

class gameController extends BaseController
{
    /**
     * @return view
     */
    public function index(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $user = User::find(Session::get('userid'));
        if($user->block == 1)
            return View::make('base.block');
        return View::make('base.game');
    }

    /**
     * @return view
     * 
     * bets the money and witdraw the cards for the dealer and the user
     */
    public function bet(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        $user = User::find(Session::get('userid'));
        //gets the user in the database by the id
        if($user->block == 1)
            return View::make('base.block');
        $bet_value = Post::get("bet_value");
        $userid = Session::get('userid');
        if($bet_value <= 0 || $bet_value > 10000 || !ctype_digit($bet_value))
            return Redirect::toRoute('base/play');
        //checks if user has any money to bet with
        if($user->money >= $bet_value){
            $user->money -= $bet_value;
            if($user->is_valid()){
                $user->save();
                //updates the user money without the bet money
                $user->update_attributes(array('money' => $user->money));

                //adds this movement to the db
                $movement = new UserMovement(array('id_user' => $userid,'money_type' => 'bet',
                                           'debito' => $bet_value,
                                           'description' => 'Bet','saldo' => $user->money));
                $movement->save();

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
                if($userHand->value == 21)
                    Session::set('user21', "1");
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

    /**
     * @return view
     * 
     * surrender, user loses half the money he bets and the game ends
     */
    public function surrender(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        //when surrender, user keeps half the money that he bet
        if(Session::has('bet_value')){
            $userid = Session::get('userid');
            //gets the user in the database by the id
            $user = User::find($userid);
            if($user->block == 1)
                return View::make('base.block');
            //updates the money
            $user->money += (Session::get('bet_value')/2);
            if($user->is_valid()){
                $user->save();
                //updates the user money in db
                $user->update_attributes(array('money' => $user->money));

                //adds this movement to the db
                $movement = new UserMovement(array('id_user' => $userid,'money_type' => 'sur',
                                           'credito' => Session::get('bet_value')/2,
                                           'description' => 'Sur','saldo' => $user->money));
                $movement->save();

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

    /**
     * @return view
     * 
     * the user stands and the dealer has to withdraw card until he gets to 16
     * after that, this function always check who is the winner
     */
    public function stand(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        //gets the user in the database by the id
        $user = User::find(Session::get('userid'));
        if($user->block == 1)
            return View::make('base.block');
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
                //updates the money
                $user->money += (Session::get('bet_value'));
                if($user->is_valid()){
                    $user->save();
                    //updates the user money in db
                    $user->update_attributes(array('money' => $user->money));

                    //adds this movement to the db
                $movement = new UserMovement(array('id_user' => $userid,'money_type' => 'win',
                                                   'credito' => Session::get('bet_value'),
                                                   'description' => 'Win','saldo' => $user->money));
                $movement->save();
                }
            }else{
                //the dealer's wins
                if($computerHand->value > $userHand->value && $computerHand->value <= 21){
                    Session::set("finalMessage", "Dealer's WIN");

                    //just reset things

                }else{
                    //the user wins
                    //gives money to user * 2
                    Session::set("finalMessage", $user->username . " WIN");
                    //updates the money
                    $user->money += (Session::get('bet_value')*2);
                    if($user->is_valid()){
                        $user->save();
                        //updates the user money in db
                        $user->update_attributes(array('money' => $user->money));

                        //adds this movement to the db
                        $movement = new UserMovement(array('id_user' => $userid,'money_type' => 'win',
                                                            'credito' => Session::get('bet_value')*2,
                                                            'description' => 'Win','saldo' => $user->money));
                        $movement->save();

                        //new code for the jackpot
                        
                        $this->addToJackpot($user,(Session::get('bet_value')*2));

                    }
                }
            }
            Session::remove('bet_value');
            Redirect::toRoute('base/play');
        }else{
            Redirect::toRoute('base/play');
        }
    }

    /**
     * @return view
     * 
     * the user asks for another card and checks if user loses
     */
    public function hit(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        //gets the user in the database by the id
        $user = User::find(Session::get('userid'));
        if($user->block == 1)
            return View::make('base.block');
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

    /**
     * @return view
     * 
     * it doubles the bet and checks if user loses
     */
    public function double(){
        if(!Session::has("userid"))
            return Redirect::toRoute('base/index');
        //gets the user in the database by the id
        $user = User::find(Session::get('userid'));
        if($user->block == 1)
            return View::make('base.block');
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
                    $this->stand();
                }
            }
        }else{
            Redirect::toRoute('base/jogar');
        }
    }

    /**
     * @param user
     * @param int
     * 
     * checks if this bet should go to jackpot or not
     */
    private function addToJackpot($user,$value_won){
        //gets all the jackpots and orders them by value_won
        $jackpot = Jackpot::find('first',array('conditions' => array('id_user=?',$user->id),
                                             'order' => 'value_won desc'));
        if(count($jackpot) == null){
            //creates the first one, when there is no other win
            $new_jackpot = new Jackpot(array("value_won" => $value_won, "username" => $user->username,"id_user" => $user->id));
            if($new_jackpot->is_valid()){
                $new_jackpot->save();
            }
        }else{
            if($jackpot->value_won < $value_won){
                $new_jackpot = new Jackpot(array("value_won" => $value_won, "username" => $user->username,"id_user" => $user->id));
                if($new_jackpot->is_valid()){
                    $jackpot->delete();
                    $new_jackpot->save();
                }
                //$jackpot->update_attributes(array("value_won" => $value_won));
            }
        }
    }
}