<?php

class CalendarConverter {

    private static $statics = [
        "difference" => 9752400,
        "minute" => 60,
        "hour" => 3600,
        "day" => 86400,
        "month" => 2592000,
        "week" => 604800,
        "year" => 31536000,

        "day_long" => [
            "",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday",
            "Monday",
            "Tuesday",
            "Wednesday"
        ],
        "day_short" => [
            "",
            "Thu",
            "Fri",
            "Sat",
            "Sun",
            "Mon",
            "Tue",
            "Wed"
        ],
        "month_long" => [
            "September",
            "October",
            "November",
            "December",
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "Pagumen"
        ],
        "month_short" => [
            "Sep",
            "Oct",
            "Nov",
            "Dec",
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Pag"
        ],
        "month_amharic" => [
            "መስከረም",
            "ጥቅምት",
            "ህዳር",
            "ታህሳስ",
            "ጥር",
            "የካቲት",
            "መጋቢት",
            "ሚያዚያ",
            "ግንቦት",
            "ሰኔ",
            "ሐምሌ",
            "ነሐሴ",
            "ጳጉሜ"
        ],
        "day_amharic" => [
            "",
            "ሐሙስ",
            "ዓርብ",
            "ቅዳሜ",
            "እሑድ",
            "ሰኞ",
            "ማክሰኞ",
            "ረቡዕ"
        ]

    ];


    public static function getDate($timestamp){
        $conv = new CalendarConverter();
        return $conv->yearCalculation($timestamp);
    }

    private function yearCalculation($given_timestamp){

        $second_count = intval($given_timestamp) + self::$statics["difference"];
        $return = [
            "number_days" => 0,
            "day_name" => 0,
            "second" => 0,
            "minute" => 0,
            "hour" => 0,
            "days" => 0,
            "month" => 0,
            "year" => 1962
        ];

        $lip_year_count = 3;
        while (true){

            if($lip_year_count == 4){

                if($second_count >= (self::$statics["year"] + self::$statics["day"])){
                    $second_count -= (self::$statics["year"] + self::$statics["day"]);
                    $return["year"] += 1;
                    $return["number_days"] += 366;
                    $lip_year_count = 1;
                }else{
                    break;
                }

            }else{

                if($second_count >= self::$statics["year"]){
                    $second_count -= self::$statics["year"];
                    $return["year"] += 1;
                    $return["number_days"] += 365;
                    $lip_year_count += 1;
                }else{
                    break;
                }

            }

        }

        $return = $this->monthCalculation($second_count, $return);
//        $calc = ((intval($given_timestamp) + self::$statics["difference"]) % self::$statics["week"]) / self::$statics["day"];
        $calc =  ($return["number_days"] % 7) + 1;
        $return["day_name"] = self::$statics["day_amharic"][$calc];
//        $return["day_name"] = $calc == 0 ? self::$statics["day_amharic"][1] : self::$statics["day_amharic"][$calc];
        return $return;

    }

    private function monthCalculation($given_timestamp, $return){

        $month_count = floor($given_timestamp / self::$statics["month"]);
        $reminder = $given_timestamp % self::$statics["month"];

        $return["month"] = $month_count + 1;
        $return["number_days"] += 30 * $month_count;
        $return["month_long"] = self::$statics["month_amharic"][$month_count];

        return $this->dayCalculation($reminder, $return);

    }

    private function dayCalculation($given_timestamp, $return){

        $day_count = floor($given_timestamp / self::$statics["day"]);
        $reminder = $given_timestamp % self::$statics["day"];

        $return["days"] = $day_count + 1;
        $return["number_days"] += $day_count;
        return $this->hourCalculation($reminder, $return);

    }

    private function hourCalculation($given_timestamp, $return){

        if($given_timestamp == 0){
            return $return;
        }

        $hour_count = floor($given_timestamp / self::$statics["hour"]);
        $reminder = $given_timestamp % self::$statics["hour"];

        $return["hour"] = $hour_count;
        return $this->minuteCalculation($reminder, $return);

    }

    private function minuteCalculation($given_timestamp, $return){

        if($given_timestamp == 0){
            return $return;
        }

        $minute_count = floor($given_timestamp / self::$statics["minute"]);
        $reminder = $given_timestamp % self::$statics["minute"];

        $return["minute"] = $minute_count;
        $return["second"] = $reminder;
        return $return;

    }

}





print_r(CalendarConverter::getDate(0));
//print_r(yearCalculation(4 * 3600));

//print date( 'Y-m-d H:i:s', -10 );

?>