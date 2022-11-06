<?php


function getLogo($placement = '' ){

    


    return 'https://w3n3u4x5.stackpathcdn.com/uploads/assets/images/logo.png?v=1.0';
}


function getCurrentDate($currentDate)
{ 
    $months = [ "Jan" => "يناير", "Feb" => "فبراير", "Mar" => "مارس", "Apr" => "أبريل", "May" => "مايو", "Jun" => "يونيو", "Jul" => "يوليو", "Aug" => "أغسطس", "Sep" => "سبتمبر", "Oct" => "أكتوبر", "Nov" => "نوفمبر", "Dec" => "ديسمبر" ];
    $day = date("d", strtotime($currentDate ));
    $month = date("M", strtotime($currentDate ));
    $year = date("Y", strtotime($currentDate ));

    $month = $months[$month];

    return $day . ' ' . $month . ' ' . $year;
 
}

