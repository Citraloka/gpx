<?php

    function gethead($url, $ua){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);

            curl_setopt($ch, CURLOPT_HEADERFUNCTION,
                function ($curl, $header) use (&$headers) {
                    $len = strlen($header);
                    $header = explode(':', $header, 2);
                    if (count($header) < 2) // ignore invalid headers
                        return $len;
                    $headers[strtolower(trim($header[0]))][] = trim($header[1]);
                    return $len;
                    }
                );
        
        $result = curl_exec($ch);
        curl_close($ch);

        //Array
        $rest = array(
            $result,
            $headers,
        );

        return $rest;
    }

    function get($url, $ua){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    function post($url, $data, $ua){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    function posthead($url, $data, $ua){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ua);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADERFUNCTION,
        function ($curl, $header) use (&$headers) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid headers
                return $len;
            $headers[strtolower(trim($header[0]))][] = trim($header[1]);
            return $len;
            }
        );
        $result = curl_exec($ch);
        curl_close($ch);

        //Array
        $res = array(
            $result,
            $headers,
        );

        return $res;

    }

    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0)
            return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    function input($text) {
        echo $text." : ";
        $a = trim(fgets(STDIN));
        return $a;
    }

    function colorLog($str, $type = 'i'){
        switch ($type) {
            case 'e': //error
                echo "\033[31m$str\033[0m";
            break;
            case 's': //success
                echo "\033[32m$str\033[0m";
            break;
            case 'w': //warning
                echo "\033[33m$str\033[0m";
            break;  
            case 'i': //info
                echo "\033[36m$str\033[0m";
            break;
            case 'abu': //abu abu
                echo "\033[90m$str\033[0m";
            break;
            case 'c': //biasa
                echo $str;
            break;      
            default:
            # code...
            break;
        }
    }

    function fakedata(){
        $fake = file_get_contents("https://api.namefake.com/indonesian-indonesia");
        $data = json_decode($fake, true);

        return $data;
    }

    function randgmail(){
        global $file_gmail;

        $files  = file($file_gmail);
        $email  = preg_replace( "/\r|\n/", "", $files );
        $cek    = count($email);
        $acak   = mt_rand(0, $cek-1);

        $email  = $email[$acak];
        $data   = array(
            $email,
            $acak,
            $cek,
        );
        
        return $data;
    }

    function delgmailfalse($no){
        global $file_gmail;

        $files  = file($file_gmail);
        
        $email  = preg_replace( "/\r|\n/", "", $files );        //Change text to array
        array_splice($email,$no,1);                             //Delete registered gmail
        $gmail  = implode("\n", $email);                         //Change array to text

        $file   = fopen($file_gmail,"w");
        fwrite($file,$gmail);                                   //Save New data
        fclose($file);
    }

    function savejson($file, $content){
        //Open file json
        $filejson = file_get_contents($file);
        $datajson = json_decode($filejson, true);

        //push content to array
        $datajson[] = $content;

        //save new data
        $datajson = json_encode($datajson, JSON_PRETTY_PRINT);
        file_put_contents($file, $datajson);
    }

    function randangka($ndx){
        $kata   = '0123456789';
        $satu   = substr(str_shuffle($kata), 0, $ndx);
    
        return $satu;
    }

    function randhurufangka($ndx){
        $kata = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = substr(str_shuffle($kata), 0, $ndx);
    
        return $rand;
    }

    function randuuid(){
        $kata   = '0123456789abcdefghijklmnopqrstuvwxyz';
        $satu   = substr(str_shuffle($kata), 0, 8);
        $dua    = substr(str_shuffle($kata), 0, 4);
        $tiga   = substr(str_shuffle($kata), 0, 4);
        $empat  = substr(str_shuffle($kata), 0, 4);
        $lima   = substr(str_shuffle($kata), 0, 12);
        $uuid   = $satu.'-'.$dua.'-'.$tiga.'-'.$empat.'-'.$lima;
    
        return $uuid;
    }

?>
