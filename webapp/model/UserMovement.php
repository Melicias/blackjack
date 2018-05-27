<?php

class UserMovement extends \ActiveRecord\Model
{

    static $table_name = "usersmovements";

    /*
    * id_user         int
    * money_type      String(3)   pay | bet | win | sur
    * credito         int
    * movement_date   DATETIME
    * description     String(35)  Carregamento XXX€ | Bet | Win | Sur
    * debito          int
    * saldo           int
    *
    */
}

?>