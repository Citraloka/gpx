<?php
    error_reporting(0);
    date_default_timezone_set("Asia/Jakarta");
    require("function.php");
    $jsonfile = "data.json";
    $file_gmail = "gmail.txt";
    $s = "\n";
    $t = "\t";

    home:
    /** Banner **/
    echo $s;
    colorLog($s."<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", "c");
    colorLog($s."                        Script GIPMX                        ", "i");
    colorLog($s."                --- Do With Your Own Risk ---               ", "i");
    colorLog($s."<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>", "c");
    colorLog($s."- Sabar ya gess ditunggu, emang lemot", "abu");
    colorLog($s."- Account saved = data.json not empty", "abu");
    colorLog($s."- Siapkan list gmail di file gmail.txt", "abu");
    colorLog($s."- Kemungkinan scam 100% akwoakwok", "abu");


    colorLog($s.$s."> ", "i").colorLog("Menu :", "abu");
    colorLog($s.$t."1. ", "i").colorLog("Login to get data", "w");
    colorLog($s.$t."2. ", "i").colorLog("Register with reff", "w");
    colorLog($s.$t."3. ", "i").colorLog("Info account               [account saved]", "w");
    colorLog($s.$t."4. ", "i").colorLog("Start mining               [account saved]", "w");
    colorLog($s.$t."5. ", "i").colorLog("Start Speed                [account saved]", "w");
    colorLog($s.$t."6. ", "i").colorLog("Relogin to get new session [account saved]", "w");
    
    colorLog($s.$s."> ", "i");
    $what = input("Your choice");

    switch ($what) {
        case '1':
            $warn = warning($what);
            if ($warn == false){
                echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
                goto home;
            }
            logingetdata();
            echo $s;
            goto home;
        break;
        case '2':
            $warn = warning($what);
            if ($warn == false){
                echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
                goto home;
            }
            goto menuone;
        break;
        case '3':
            menutwo();
            echo $s;
            goto home;
        break;
        case '4':
            menuthreeandfour($what);
            echo $s;
            goto home;
        break;
        case '5':
            menuthreeandfour($what);
            echo $s;
            goto home;
        break;
        case '6':
            $warn = warning($what);
            if ($warn == false){
                echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
                goto home;
            }
            getseswithlogin();
            echo $s;
            goto home;
        break;
        default:
            colorLog("> ", "i").colorLog("Selected menu does not exist", "w");
            echo $s;
            goto home;
        break;
    }

    menuone:
    colorLog($s."> ", "i");
    $reff = input("Kode Reff");


    /** Get Session */
    $ses = getsession();

        //Change header , add session in cookie
        $headregis  = array(
            "Host: www.gip-app1.com",
            "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
            "Cookie: ".$ses,
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
        );


    /** Check Reff */
    colorLog($s."> ", "i").colorLog("Get id & name reff . . . ", "c").colorLog("[".$reff."]", "abu");

    $url_reff   = "https://www.gip-app1.com/?action=g_app_up&dt=bring_mb_info";
    $d_reff     = 'id='.$reff;
    do{
        $post_reff  = post($url_reff, $d_reff, $headregis);
    } while ($post_reff ==  null);

        //Parsing id&name reff
        $cut_reff   = explode("|", $post_reff);
        $id_reff    = $cut_reff[1];
        $name_reff  = str_replace(' ', '+', $cut_reff[2]);

        colorLog($s."> ", "i").colorLog("Id|Name reff = ", "c").colorLog($id_reff."|".$name_reff, "s");


    getfakeuser:
    colorLog($s."> ", "i").colorLog("Try generate data register ", "abu");

    /** Data Register */
    $datagmail  = randgmail();      //Random Email form txt
    $simail     = str_replace('@', '%40', $datagmail[0]);
    $noemail    = $datagmail[1];

    $d_user  = fakedata();          //fake data user
    $name    = str_replace(' ', '+', $d_user["name"]);
    $u_name  = $d_user["username"];

    $no_indo        = ["22","23","52","11","13","14","59","77","78","17","18","19","98","99","95","96","97","58","57","56","55","16","15"];     //random nomer provider indo
    $jml_no_indo    = count($no_indo);
    $rand_no_indo   = mt_rand(0, $jml_no_indo-1);
    $nohp           = "8".$no_indo[$rand_no_indo].randangka(8);


    /** Check iduser */
    $url_idu   = "https://www.gip-app1.com/?action=g_app_up&dt=check_mb_userid";
    $d_idu     = 'id='.$u_name;
    do{
        $post_idu  = post($url_idu, $d_idu, $headregis);
    } while ($post_idu ==  null);
    //response = 0|'username'

    $cut_idu   = explode("|", $post_idu);

    if($cut_idu[0] != '0' && $cut_idu[1] != $u_name){
        colorLog($s."> ", "i").colorLog("Username not available to use ", "w");
        goto getfakeuser;
    }
    colorLog($s."> ", "i").colorLog("Username available to use ", "s");


    colorLog($s."> ", "i").colorLog("Data register account", "c");
    colorLog($s."  - ", "i").colorLog("Name : ", "c").colorLog($name, "abu");
    colorLog($s."  - ", "i").colorLog("Username : ", "c").colorLog($u_name, "abu");
    colorLog($s."  - ", "i").colorLog("Email : ", "c").colorLog($simail, "abu");
    colorLog($s."  - ", "i").colorLog("No hp : ", "c").colorLog("08".$nohp, "abu");

    
    register:
    /** Register */
    $url_regis   = "https://www.gip-app1.com/?action=g_app_up&dt=mb_join&cn=Indonesia";
    $d_regis     = 'r_id='.$reff.'&r_code='.$id_reff.'&r_name='.$name_reff.'&m_name='.$name.'&m_id='.$u_name.'&id2='.$u_name.'&available=ok&email='.$simail.'&m_tel='.$nohp.'&cn=62'; //nanti beberapa dirandom yaa...!!!
    do{
        $post_regis  = post($url_regis, $d_regis, $headregis);
    } while ($post_regis ==  null);
    //response = 0|Wecome!Default password is '1111'|'usename'

    $cut_regis   = explode("|", $post_regis);

    if($cut_regis[0] != '0' && $cut_regis[2] != $u_name){
        goto register;
    }

    colorLog($s."> ", "i").colorLog($cut_regis[1], "s");


        //Delete Email registered
        delgmailfalse($noemail);


    /** Login */
    $ses2 = login($u_name, $headregis);


        colorLog($s."> ", "i").colorLog("Save data to data.json", "c");
        //Save data session ($ses & $ses2) in file json
        $session = $ses."; ".$ses2;
                            
        $data_save = [                     
            "username" => $u_name,
            "ses" => $session,
        ];
        savejson($jsonfile, $data_save);
        colorLog($s."> ", "i").colorLog("Saved !", "abu");


            //Change header, add uid in cookie
            $headlog  = array(
                "Host: www.gip-app1.com",
                "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
                "Cookie: ".$session,
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
            );
            $headlog2  = array(
                "Host: www.gip-app1.com",
                "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
                "Cookie: ".$session,
            );
    
    mining($headlog);
    speedon($headlog);

    goto home;
    


    /** Get Session */
    function getsession(){
        global $s;

        colorLog("> ", "i").colorLog("Get Session . . .", "c");

        $head  = array(
            "Host: www.gip-app1.com",
            "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
        );
        $url_ses = "https://www.gip-app1.com/";
        do {
            $get_ses = gethead($url_ses, $head);
            $dh_ses = $get_ses[1];
        } while($dh_ses["set-cookie"] == null);
            //Parsing Cookie
            $coki  = explode("; ", $dh_ses["set-cookie"][0]);
            $ses   = $coki[0]; 

            colorLog($s."> ", "i").colorLog("Session : ".$ses, "abu");

        return $ses;
    }

    /** Login */
    function login($usr_name, $headreg){
        global $s;

        colorLog($s."> ", "i").colorLog("Try to login", "abu");

        $url_login   = "https://www.gip-app1.com/?action=g_app_up&dt=login";
        $d_login     = 'm_id='.$usr_name.'&m_pw=1111'; //password default from dev '1111'
        do{
            $post_login  = posthead($url_login, $d_login, $headreg);
        } while ($post_login[1]["set-cookie"] ==  null);
        //response = 0

        colorLog($s."> ", "i").colorLog("Login sukses", "s");

        //Get new cookie
        $dh_login = $post_login[1];
        $coki  = explode("; ", $dh_login["set-cookie"][0]);
        $ses2  = $coki[0];
        
        return $ses2;
    }

    /** Minning on */
    function mining($headlogin){
        global $s;

        colorLog($s."> ", "i").colorLog("Start mining . . .", "abu");

        $url_mining   = "https://www.gip-app1.com/?action=g_app_up&dt=start_mining";
        $d_mining     = 'mining=1'; //1 = on
        do{
            $post_mining  = post($url_mining, $d_mining, $headlogin);

            if ($post_mining == '0'){
                break;
            }
        } while ($post_mining ==  null);
        //response = 0

        if ($post_mining != '0'){
            colorLog($s."> ", "i").colorLog("Something error | ".$post_mining, "w");
            return false;
        }

        colorLog($s."> ", "i").colorLog("Done", "s");
        return true;
    }

    /** Speed on */
    function speedon($headlogin){
        global $s;

        colorLog($s."> ", "i").colorLog("Start Speed . . .", "abu");

        $url_speed   = "https://www.gip-app1.com/?action=g_app_up&dt=start_speed";
        $d_speed     = ''; //emang kosong anjg
        do{
            $post_speed  = post($url_speed, $d_speed, $headlogin);

            if ($post_speed == '0'){
                break;
            }
        } while ($post_speed ==  null);
        //response = 0

        if ($post_speed != '0'){
            colorLog($s."> ", "i").colorLog("Something error | ".$post_speed, "w");

            return false;
        }

        colorLog($s."> ", "i").colorLog("Done", "s");
        return true;
    }

    /** Cek expired mining */
    function cekmining($headlogin2){
        global $s;

        $url_emining   = "https://www.gip-app1.com/?pg=mining";
        do{
            $get_emining  = get($url_emining, $headlogin2);
        } while ($get_emining == null);
        //response ?, YNTKTS

        return $get_emining;
    }

    /** Cek expired speed */
    function cekspeed($headlogin2){
        global $s;

        $url_espeed   = "https://www.gip-app1.com/?pg=speed";
        do{
            $get_espeed  = get($url_espeed, $headlogin2);
        } while ($get_espeed ==  null);
        //response ?, YNTKTS

        return $get_espeed;
    }

    /** Cek Wallet */
    function cekwallet($headlogin2){
        global $s;

        $url_wallet   = "https://www.gip-app1.com/?pg=wallet";
        do{
            $get_wallet  = get($url_wallet, $headlogin2);
        } while ($get_wallet ==  null);
        //response ?, YNTKTS

        return $get_wallet;
    }

    /** Feature Warning */
    function warning($no){
        global $s,$t;
    
        colorLog("> ", "i").colorLog("Warning :", "w");
    
        if ($no == "1"){
            $data = PHP_EOL
                    .$t."- Menu No-$no. Login akun with input username".PHP_EOL
                    .$t."- Password akun harus default '1111'".PHP_EOL
                    .$t."- Data akun save di data.json".PHP_EOL;
        } elseif ($no == "2"){
            $data = PHP_EOL
                     .$t."- Menu No-$no. Register new akun".PHP_EOL
                     .$t."- Data akun save di data.json".PHP_EOL;
        } elseif ($no == "6"){
            $data = PHP_EOL
                     .$t."- Menu No-$no. Login akun kembali dari file data.json".PHP_EOL
                     .$t."  untuk ambil session terbaru".PHP_EOL
                     .$t."- Password akun harus default '1111'".PHP_EOL;
        }
    
        colorLog($data, "abu");
    
        colorLog($s."> ", "i");
        $yn = strtoupper(input("Do you want continue (y/n)"));
    
        if ($yn == "Y"){
            return true;
        } else{
            return false;
        }
    }


function logingetdata(){
    global $s,$t,$jsonfile;


    colorLog($s."> ", "i");
    $user = input("Username");
    colorLog("> ", "i").colorLog("Password default '1111' ", "c");
    echo $s;


    /** Get Session */
    $ses = getsession();

            //Change header , add session in cookie
            $headregis  = array(
                "Host: www.gip-app1.com",
                "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
                "Cookie: ".$ses,
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
            );
  

    /** Login */
    $ses2 = login($user, $headregis);

            //Save data session ($ses & $ses2) in file json
            colorLog($s."> ", "i").colorLog("Save new data . . .", "abu");
            $session  = $ses."; ".$ses2;

                //load
                $filejson = file_get_contents($jsonfile);
                $dataacc  = json_decode($filejson, true);

                //Checking if data exist in data.json
                $arryclm  = array_column($dataacc, 'username');
                $cariarry = array_search($user, $arryclm);

                if($cariarry === false){
                    $data_save = [                     
                        "username" => $user,
                        "ses" => $session,
                    ];
                    savejson($jsonfile, $data_save);
                } else {
                    $dataacc[$cariarry]["ses"] = $session;
                    $datajson = json_encode($dataacc, JSON_PRETTY_PRINT);
                    file_put_contents($jsonfile, $datajson);
                }
                unset($arryclm);
            

    colorLog($s."> ", "i").colorLog("Done", "s");
}    


function getseswithlogin(){
    global $s,$t,$jsonfile;

    /** Get Old Data */
    $filejson = file_get_contents($jsonfile);
    $dataacc  = json_decode($filejson, true);
    $jmlacc   = count($dataacc)-1;

    for($yz=0 ; $yz<=$jmlacc ; $yz++){
        $u_name = $dataacc[$yz]["username"];
        
        $no_gpx = $yz+1;
        colorLog($s."> ", "i").colorLog($u_name, "w").colorLog(" [".$no_gpx."]", "abu");
        echo $s;


        /** Get Session */
        $ses = getsession();

            //Change header , add session in cookie
            $headregis  = array(
                "Host: www.gip-app1.com",
                "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
                "Cookie: ".$ses,
                "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
            );
  

        /** Login */
        $ses2 = login($u_name, $headregis);

            //Save data session ($ses & $ses2) in file json
            colorLog($s."> ", "i").colorLog("Save new data . . .", "abu");
            
            $session  = $ses."; ".$ses2;
            $dataacc[$yz]["ses"] = $session;
            $datajson = json_encode($dataacc, JSON_PRETTY_PRINT);
            file_put_contents($jsonfile, $datajson);

        colorLog($s."> ", "i").colorLog("Done", "s");
    }
}


function menutwo(){
    global $s,$t,$jsonfile;

    colorLog($s."> ", "i").colorLog("Load data . . .", "abu");

    //Open file json
    $filejson = file_get_contents($jsonfile);
    $dataacc  = json_decode($filejson, true);

    colorLog($s."> ", "i").colorLog("List Data :", "c");

    foreach($dataacc as $acc){
        colorLog($s.$t.$t."- ", "i").colorLog($acc["username"], "w");
        
        $headlog2  = array(
            "Host: www.gip-app1.com",
            "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
            "Cookie: ".$acc["ses"],
        );     


        //Info wallet
        $wallet = cekwallet($headlog2);
        $balance_wallet = get_string_between($wallet, '<h2 class="mt-1 mb-0">', '</h2>');
        colorLog($s.$t.$t."  Balance ".$t.": ", "abu").colorLog(trim($balance_wallet)." GIP", "s");

        //Info mining 
        $mining     = cekmining($headlog2);
        $search     = '<p style="margin-top:200px;">';
        $position   = strpos($mining, $search);
            
            if ($position === false) {
                colorLog($s.$t.$t."  Mining ".$t.": ", "abu").colorLog("Not running", "e");
            } else {
                $exp_mining = get_string_between($mining, '<p style="margin-top:200px;">', '</p>');
                colorLog($s.$t.$t."  Mining ".$t.": ", "abu").colorLog($exp_mining, "c");
            }

        //Info speed
        $speed      = cekspeed($headlog2);
        $position2  = strpos($speed, $search);

            if ($position2 === false) {
                colorLog($s.$t.$t."  Speed ".$t.": ", "abu").colorLog("Not running", "e");
            } else {
                $exp_speed  = get_string_between($speed, '<p style="margin-top:200px;">', '</p>');
                colorLog($s.$t.$t."  Speed ".$t.": ", "abu").colorLog($exp_speed, "c");
            }

    }

}


function menuthreeandfour($number){
    global $s,$t,$jsonfile;

    colorLog($s."> ", "i").colorLog("Load data . . .", "abu");

    //Open file json
    $filejson = file_get_contents($jsonfile);
    $dataacc  = json_decode($filejson, true);

    colorLog($s."> ", "i").colorLog("List Data :", "c");

    foreach($dataacc as $acc){
        colorLog($s."> ", "i").colorLog($acc["username"], "w");
        
        $headlog = array(
            "Host: www.gip-app1.com",
            "User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; SM-G988N Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/92.0.4515.131 Mobile Safari/537.36",
            "Cookie: ".$acc["ses"],
            "Content-Type: application/x-www-form-urlencoded; charset=UTF-8"
        );

        if($number == "4"){
            mining($headlog);
        } elseif($number == "5"){
            speedon($headlog);
        }
    
    }
}
