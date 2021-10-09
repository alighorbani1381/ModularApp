<?php

namespace Alighorbani\Helpers;

use Exception;
use Hekmatinasser\Verta\Facades\Verta;

class PersianDatePicker
{

    /**
     * Convert Characters from persian number to english number
     * 
     * @param string $string
     * 
     * @return string
     */
    private static function convertStringToEn($string)
    {
        return strtr($string, ['۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9', '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9']);
    }

    /**
     * Separate Shamsi Date Items
     * like this 1399/12/11 => 1399, 12, 12
     * 
     * @param string $orderdate
     * 
     * @return array $date
     */
    private static function separateDateItems($orderdate)
    {

        $explodeDate = explode('/', $orderdate);

        $date[0]   = $explodeDate[0];

        $date[1] = $explodeDate[1];

        $date[2]  = $explodeDate[2];

        return $date;
    }

    /**
     * Convert to integer numbers
     * 
     * loops from all date character passed and cast to integer
     * 
     * @param array $date
     * 
     * @return array $numberDate
     */
    private static function convertToInt($date)
    {
        foreach ($date as $dateParam) {
            $englishCharacters[] = self::convertStringToEn($dateParam);
        }

        foreach ($englishCharacters as $englishChar) {
            $numberDate[] = (int) $englishChar;
        }

        return $numberDate;
    }

    /**
     * Make gregorian format (Y-m-d)
     * 
     * this format support by mysql passed
     * 
     * @param array $arrayDate
     * 
     * @return string 
     */
    private static function getGregorianFormat($arrayDate)
    {
        return implode('-', $arrayDate);
    }

    /**
     * Convert Simple text to gregorian valid date
     * get simple text from PersianDatePicker and change it to valid date used for proccess
     * 
     * @param string
     * 
     * @return string $gregorianDate
     */
    public static function convertToGregorian($jalaliDate)
    {
        try {
            $date = self::separateDateItems($jalaliDate);

            $numberDate = self::convertToInt($date);

            $newDate = Verta::getGregorian($numberDate[0], $numberDate[1], $numberDate[2]);

            $gregorianDate = self::getGregorianFormat($newDate);

            $stableDate = Verta::instance($gregorianDate)->formatGregorian('Y-m-d');

            return $stableDate;
        } catch (Exception $e) {
            return [];
        }
    }
}
