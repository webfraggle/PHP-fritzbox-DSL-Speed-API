<?php

function loadData()
{
    global $data;
    if (file_exists('data.dat'))
    {
        $tmp = file_get_contents('data.dat');
        $data = unserialize($tmp);
    } else {
        $data = [];
        $data['SID'] = '';
    }
}

function saveData()
{
    global $data;
    // print_r($data);
    file_put_contents('data.dat', serialize($data));
}
?>