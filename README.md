# Project Title

This is the blackjack game made by Francisco Melicias

## Getting Started

### Prerequisites

You will need to run one of the 2 databases <br />
	You can find the 2 databases in the folder db_blackjack <br />
	bd_with_data_Melicias.sql      -> database with data <br />
	bd_without_data_Melicias.sql   -> database without data <br />
	
	Users_Passwords.txt            -> file with all users and admin passwords

## How does the website works

### Without login

**Home**          -> show a page that shows how does the game works <br />
**JackPot 10**     -> if there is any jackpots it shows the 10 biggest <br />
**Sign up / Login** -> To sign up or login <br />
					All fields are "protected" with html and php checks all fields <br />
						php checks nulls, sizes, if is an email <br />
					MISSING: check date of birth if its old enough <br />

### With login

**Home**          -> show a page that shows how does the game works <br />
**Play** 		  -> Place to play the game -> the Deck has 5 decks inside and when it gets to 2 decks, it will shuffle 5 decks again
	* BET -> when the bet is valid (bet value > 0 and bet value < 10000) it withdraws one card to the user, other to the dealer and another one to the user
	* STAND -> dealers withdraws card until he reaches 17
	* HIT -> withdraw one card to the user
	* DOUBLE -> If user has money, it doubles user bet and giver only one more card to the user and them dealer withdraw cards until he reaches 17
	* SURRENDER -> User loses the game but keeps half the bet value
	MISSING: when user is playing dont let user logout or change page <br />
**Personal area**     -> Where you can check your last 10 moviments and you can see and add funds <br />
**JackPot 10**     -> if there is any jackpots it shows the 10 biggest AND if shows user biggest win <br />
**Logout** -> Session destroy <br />

### Admin

**Users**          -> Shows a page where you can block/unblock users <br />
**Admins**     -> Shows a page where you can block/unblock admins -> only SuperAdmin can use this <br />
**Cange Password** -> Shows a page where Admin can change his password <br />
**Logout** -> Logout admin <br />

## All pages

### Without login

127.0.0.1/blackjack/webapp/ <br />
127.0.0.1/blackjack/webapp/base/play <br />
127.0.0.1/blackjack/webapp/base/personalArea <br />
127.0.0.1/blackjack/webapp/base/jackpot10 <br />

### With login

127.0.0.1/blackjack/webapp/ <br />
127.0.0.1/blackjack/webapp/base/jackpot10 <br />
127.0.0.1/blackjack/webapp/base/regist_login <br />

### Admin

127.0.0.1/blackjack/webapp/admin <br />
127.0.0.1/blackjack/webapp/admin/login <br />
127.0.0.1/blackjack/webapp/admin/users <br />
127.0.0.1/blackjack/webapp/admin/admins <br />
127.0.0.1/blackjack/webapp/admin/changePassword <br />

