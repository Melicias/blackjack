# Project Title

This is the blackjack game made by Francisco Melicias

## Getting Started

### Prerequisites

You will need to run one of the 2 databases
	You can find the 2 databases in the folder db_blackjack
	bd_with_data_Melicias.sql      -> database with data
	bd_without_data_Melicias.sql   -> database without data
	
	Users_Passwords.txt            -> file with all users and admin passwords

## How does the website works

### Without login

Home            -> show a page that shows how does the game works
JackPot 10      -> if there is any jackpots it shows the 10 biggest
Sign up / Login -> To sign up or login
					All fields are "protected" with html and php checks all fields
						php checks nulls, sizes, if is an email
					MISSING: check date of birth if its old enough

