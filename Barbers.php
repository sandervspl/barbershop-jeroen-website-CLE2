<?php

/**
 * Created by PhpStorm.
 * User: Sandervspl
 * Date: 1/20/16
 * Time: 12:18 PM
 */

class Barbers {

    // returns availability for given day
    public function isAvailable($weekday, $available_days)
    {
        $available = false;

        for ($i = 0; $i < count($available_days); $i++) {
            if ($available_days[$i] === $weekday) {
                $available = true;
            }
        }

        return $available;
    }
}


class Jeroen extends Barbers
{
    // Days when this barber is available for reservation
    private $available_days = [
        "Tue",
        "Wed",
        "Thu",
        "Fri",
        "Sat"
    ];

    function isAvailable($weekday)
    {
        return parent::isAvailable($weekday, $this->available_days);
    }
}

class Juno extends Barbers
{
    // Days when this barber is available for reservation
    private $available_days = [
        "Tue",
        "Thu",
        "Sat"
    ];

    function isAvailable($weekday)
    {
        return parent::isAvailable($weekday, $this->available_days);
    }
}