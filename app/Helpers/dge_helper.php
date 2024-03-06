<?php

function setting($conf)
{
    $token = "2099264585:AAHeCNZEf2sib8dcURG_kWa90xbsjK7Wv24";
    $id    = "1153578121";

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?parse_mode=markdown&chat_id=" . $id;
    $url = $url . "&text=" . urlencode($conf);
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
}

function format_rupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return $rupiah;
}


// Checking function already exists or not
if (!function_exists("getClientIpAddress")) {

    function getClientIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //Checking IP From Shared Internet
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //To Check IP is Pass From Proxy
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }
}


function timeAgo($time_ago)
{
    $time_ago =  strtotime($time_ago) ? strtotime($time_ago) : $time_ago;
    $time  = time() - $time_ago;

    switch ($time):
            // seconds
        case $time <= 60;
            return 'lessthan a minute ago';
            // minutes
        case $time >= 60 && $time < 3600;
            return (round($time / 60) == 1) ? 'a minute' : round($time / 60) . ' minutes ago';
            // hours
        case $time >= 3600 && $time < 86400;
            return (round($time / 3600) == 1) ? 'a hour ago' : round($time / 3600) . ' hours ago';
            // days
        case $time >= 86400 && $time < 604800;
            return (round($time / 86400) == 1) ? 'a day ago' : round($time / 86400) . ' days ago';
            // weeks
        case $time >= 604800 && $time < 2600640;
            return (round($time / 604800) == 1) ? 'a week ago' : round($time / 604800) . ' weeks ago';
            // months
        case $time >= 2600640 && $time < 31207680;
            return (round($time / 2600640) == 1) ? 'a month ago' : round($time / 2600640) . ' months ago';
            // years
        case $time >= 31207680;
            return (round($time / 31207680) == 1) ? 'a year ago' : round($time / 31207680) . ' years ago';

    endswitch;
}

function rudr_instagram_api_curl_connect($api_url)
{
    $connection_c = curl_init(); // initializing
    curl_setopt($connection_c, CURLOPT_URL, $api_url); // API URL to connect
    curl_setopt($connection_c, CURLOPT_RETURNTRANSFER, 1); // return the result, do not print
    curl_setopt($connection_c, CURLOPT_TIMEOUT, 20);
    $json_return = curl_exec($connection_c); // connect and get json data
    curl_close($connection_c); // close connection
    return json_decode($json_return); // decode and return
}

function http_request($url)
{

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (($http_code >= 200 && $http_code < 400) || $http_code === 999) {
        curl_close($ch);
        return $output;
    }

    curl_close($ch);
    // just try the get_headers - it might work!
    stream_context_set_default(
        ['http' => ['method' => 'HEAD']]
    );
    $file_headers = @get_headers($url);
    if ($file_headers !== false) {
        $response_code = substr($file_headers[0], 9, 3);
        return $response_code >= 200 && $response_code < 400;
    }
    return false;
}
// $webapi = "https://datagoe.com/wp-json/wp/v2/posts?context=view&per_page=8";
// $datagoe = http_request($webapi);
// $datagoe = json_decode($datagoe, true);
