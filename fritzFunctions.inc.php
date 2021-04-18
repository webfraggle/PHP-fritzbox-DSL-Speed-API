<?php

function checkSession($debug=false)
{
    global $data, $fritz_url, $fritz_pwd,$fritz_user;
    $tmp = simplexml_load_string(file_get_contents($fritz_url."/login_sid.lua?sid=".$data['SID']));
    if ($tmp->BlockTime > 0) {
        sleep($tmp->BlockTime);
        $tmp = simplexml_load_string(file_get_contents($fritz_url."/login_sid.lua?sid=".$data['SID']));
    }
    if ($debug) print_r('Got challenge: ' . $tmp->asXML() . PHP_EOL);
    if ($debug) print_r((String)$tmp->SID . '--'. PHP_EOL) ;

    $SID = (String)$tmp->SID;
    if ($SID == "0000000000000000")
    {
        $challenge = $tmp->Challenge;
        // Get SID
        $challenge_str = $challenge . '-' . $fritz_pwd;
        if ($debug) print_r( $challenge_str. PHP_EOL);
        // if ($debug) print_r(md5(iconv("UTF-8", "UTF-16LE", '1234567z-äbc')). PHP_EOL);
        $md_str = md5(iconv("UTF-8", "UTF-16LE", $challenge_str));
        $response = $challenge . '-' . $md_str;
        if ($debug) print_r($response. PHP_EOL);
        $tmp = simplexml_load_string(file_get_contents($fritz_url . '/login_sid.lua?user=' .
        $fritz_user . '&response=' . $response));
        if ($debug) print_r((String)$tmp->SID);
        $data['SID'] = (String)$tmp->SID;
        if ($debug) print_r(' Got session ID: ' . $tmp->asXML() . PHP_EOL);
    } 
}

function logout($debug=false)
{
    global $data, $fritz_url, $fritz_pwd,$fritz_user;
    $tmp = simplexml_load_string(file_get_contents($fritz_url . '/login_sid.lua?logout=1&sid=' . $data['SID']));
    if ($debug) {
        print_r(' Logout: ' . $tmp->asXML() . PHP_EOL);
    }
}
?>