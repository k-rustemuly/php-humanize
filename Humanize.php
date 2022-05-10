<?php

namespace Humanize;

use UnexpectedValueException;
/**
 * @author Osmanov Kuanysh <kuanish@mail.kz>
 * @link https://github.com/k_rustemuly/humanize
 */

class Humanize
{
    /**
     * @var int
     */
    private static $seconds = 0;

    /**
     * @var int
     */
    private static $minutes = 0;

    /**
     * @var int
     */
    private static $hours = 0;

    /**
     * @var int
     */
    private static $days = 0;

    /**
     * @var int
     */
    private static $months = 0;

    /**
     * @var int
     */
    private static $years = 0;

    /**
     * kk - Kazakh
     * ru - Russian
     * en - English
     * @var string 
     */
    private static $lang = "kk";

    /**
     * @var array
     */
    private static $dictionary = array(
        "kk" => array(
            "year" => "жыл",
            "years" => "жыл",
            "year_" => "жыл",
            "month" => "ай",
            "months" => "ай",
            "month_" => "ай",
            "day" => "күн",
            "days" => "күн",
            "day_" => "күн",
            "hour" => "сағат",
            "hours" => "сағат",
            "hour_" => "сағат",
            "minute" => "минут",
            "minutes" => "минут",
            "minute_" => "минут",
            "second" => "секунд",
            "seconds" => "секунд",
            "second_" => "секунд",
            "humanize" => '%1$s және %2$s'
        ),
        "ru" => array(
            "year" => "год",
            "years" => "года",
            "year_" => "лет",
            "month" => "месяц",
            "months" => "месяцев",
            "month_" => "месяца",
            "day" => "день",
            "days" => "дней",
            "day_" => "дня",
            "hour" => "час",
            "hours" => "часов",
            "hour_" => "часа",
            "minute" => "минут",
            "minutes" => "минуты",
            "minute_" => "минута",
            "second" => "секунд",
            "seconds" => "секунды",
            "second_" => "секунда",
            "humanize" => '%1$s и %2$s'
        ),
        "en" => array(
            "year" => "year",
            "years" => "years",
            "year_" => "years",
            "month" => "month",
            "months" => "months",
            "month_" => "months",
            "day" => "day",
            "days" => "days",
            "day_" => "days",
            "hour" => "hour",
            "hours" => "hours",
            "hour_" => "hours",
            "minute" => "minute",
            "minutes" => "minutes",
            "minute_" => "minutes",
            "second" => "second",
            "seconds" => "seconds",
            "second_" => "seconds",
            "humanize" => '%1$s and %2$s'
        )
    );

    /**
     * @var array
     */
    private static $queue = array(
        "years",
        "months",
        "days",
        "hours",
        "minutes",
        "seconds"
    );
    private static $_instance = null;

    public static function getInstance ()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @param string $lang
     */
    public static function lang(string $lang = "kk"): self{
        static::$lang = $lang;
        return self::getInstance();
    }

    /**
     * Set seconds (only positive numbers)
     * 
     * @throws UnexpectedValueException     Provided seconds was invalid
     */
    public static function seconds(int $seconds = 0): self{
        if($seconds < 0) {
            throw new UnexpectedValueException('Seconds value is negative');
        }
        static::$seconds += $seconds;
        return self::getInstance();
    }

    /**
     * Set minutes (only positive numbers)
     * 
     * @throws UnexpectedValueException     Provided minutes was invalid
     */
    public static function minutes(int $minutes = 0): self{
        if($minutes < 0) {
            throw new UnexpectedValueException('Minutes value is negative');
        }
        static::$minutes += $minutes;
        return self::getInstance();
    }

    /**
     * Set hours (only positive numbers)
     * 
     * @throws UnexpectedValueException     Provided hours was invalid
     */
    public static function hours(int $hours = 0): self{
        if($hours < 0) {
            throw new UnexpectedValueException('Hours value is negative');
        }
        static::$hours += $hours;
        return self::getInstance();
    }

    /**
     * Set days (only positive numbers)
     * 
     * @throws UnexpectedValueException     Provided days was invalid
     */
    public static function days(int $days = 0): self{
        if($days < 0) {
            throw new UnexpectedValueException('Days value is negative');
        }
        static::$days += $days;
        return self::getInstance();
    }

    /**
     * Set months (only positive numbers)
     * 
     * @throws UnexpectedValueException     Provided months was invalid
     */
    public static function months(int $months = 0): self{
        if($months < 0) {
            throw new UnexpectedValueException('Months value is negative');
        }
        static::$months += $months;
        return self::getInstance();
    }

    /**
     * Set years (only positive numbers)
     * 
     * @throws UnexpectedValueException     Provided years was invalid
     */
    public static function years(int $years = 0): self{
        if($years < 0) {
            throw new UnexpectedValueException('Years value is negative');
        }
        static::$years += $years;
        return self::getInstance();
    }

    /**
     * Calculate 
     * 
     * @param string        $minimum_unit   The minimum unit for show or return [seconds, minutes, hours, days, months, years]
     * @param array<string> $supress        If desired, some units can be suppressed: you will not see them represented and the time of the other units will be adjusted [seconds, minutes, hours, days, months, years]
     * 
     * @return string
     */
    public static function calc(string $minimum_unit = "seconds", array $supress = array()): string{
        $humanize = array();
        if(static::$seconds > 59) {
            $minutes = (int) (static::$seconds / 60);
            static::$minutes += $minutes;
            static::$seconds -= $minutes*60;
        }

        if(static::$minutes > 59) {
            $hours = (int) (static::$minutes / 60);
            static::$hours += $hours;
            static::$minutes -= $hours*60;
        }

        if(static::$hours > 23) {
            $days = (int) (static::$hours / 24);
            static::$days += $days;
            static::$hours -= $days*24;
        }

        if(static::$days > 29) {
            if(static::$days >= 365) {
                $years = (int) (static::$days / 365);
                static::$years += $years;
                static::$days -= $years*365;
            }
            $months = (int) (static::$days / 30);
            static::$months += $months;
            static::$days -= $months*30;
            
        }

        if(static::$months > 11) {
            $years = (int) (static::$months / 12);
            static::$years += $years;
            static::$months -= $years*12;
        }

        if(static::$seconds > 0) {
            $seconds = static::$dictionary[static::$lang]["second"];
            if(static::$seconds % 10 == 1 && static::$seconds != 11) {
                $seconds = static::$dictionary[static::$lang]["second_"];
            } else if(static::$seconds % 10 >=2 && static::$seconds % 10 <=4 && (int)(static::$seconds/10) != 1) {
                $seconds = static::$dictionary[static::$lang]["seconds"];
            }
            $humanize["seconds"] = static::$seconds.' '.$seconds;
        }

        if(static::$minutes > 0) {
            $minutes = static::$dictionary[static::$lang]["minute"];
            if(static::$minutes % 10 == 1 && static::$minutes != 11) {
                $minutes = static::$dictionary[static::$lang]["minute_"];
            } else if(static::$minutes % 10 >=2 && static::$minutes % 10 <=4 && (int)(static::$minutes/10) != 1) {
                $minutes = static::$dictionary[static::$lang]["minutes"];
            }
            $humanize["minutes"] =  static::$minutes.' '.$minutes;
        }

        if(static::$hours > 0) {
            switch (static::$hours) {
                case 1:
                case 21:
                    $hours = static::$dictionary[static::$lang]["hour"];
                break;
                case 2:
                case 3:
                case 4:
                case 22:
                case 23:
                    $hours = static::$dictionary[static::$lang]["hour_"];
                break;
                default: 
                    $hours = static::$dictionary[static::$lang]["hours"];
                break;
            }
            $humanize["hours"] = static::$hours.' '.$hours;
        }

        if(static::$days > 0) {
            if(static::$days % 100 >= 11 && static::$days % 100 <= 14) {
                $day = static::$dictionary[static::$lang]["days"];
            } else {
                $mod = static::$days % 10;
                switch ($mod) {
                    case 1: 
                        $day = static::$dictionary[static::$lang]["day"];
                    break;
                    case 2: 
                    case 3:
                    case 4:
                        $day = static::$dictionary[static::$lang]["day_"];
                    break;
                    default:
                        $day = static::$dictionary[static::$lang]["days"];
                    break;
                }
            }
            $humanize["days"] = static::$days.' '.$day;
        }

        if(static::$months > 0) {
            if(static::$months % 100 >= 11 && static::$months % 100 <= 14) {
                $month = static::$dictionary[static::$lang]["months"]; //месяцев
            } else {
                $mod = static::$months % 10;
                switch ($mod) {
                    case 0: 
                    case 5: 
                        $month = static::$dictionary[static::$lang]["months"]; //месяцев
                    break;
                    case 1: 
                        $month = static::$dictionary[static::$lang]["month"]; // месяц
                    break;
                    case 2: 
                        $month = static::$dictionary[static::$lang]["month_"]; // месяца
                    break;
                }
            }
            $humanize["months"] = static::$months.' '.$month;
        }

        if(static::$years > 0) {
            if(static::$years % 100 >=11 && static::$years % 100 <= 14) {
                $year = static::$dictionary[static::$lang]["year_"]; // лет
            } else {
                $mod = static::$years % 10;
                switch ($mod) {
                    case 0: 
                    case 5: 
                        $year = static::$dictionary[static::$lang]["year_"]; // лет
                    break;
                    case 1: 
                        $year = static::$dictionary[static::$lang]["year"]; // год
                    break;
                    case 2: 
                        $year = static::$dictionary[static::$lang]["years"]; // год
                    break;
                }
            }
            $humanize["years"] = static::$years.' '.$year;
        }

        if(!empty($supress)) {
            foreach($supress as $s) {
                if(isset($humanize[$s])) unset($humanize[$s]);
            }    
        }

        $toStr = array();
        foreach(static::$queue as $item) {
            if(isset($humanize[$item])) {
                $toStr[] = $humanize[$item];
            }
            if($item == $minimum_unit) break;
        }
        //return implode(", ", $toStr);
        if(count($toStr) > 1) {
            $str = sprintf(static::$dictionary[static::$lang]["humanize"], implode(", ", array_slice($toStr, 0, count($toStr)-1)), $toStr[count($toStr)-1]);
        } else {
            $str = $toStr[0];
        }
        return $str;
    }
}