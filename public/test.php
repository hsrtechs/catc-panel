<?php
header('Content-Type: application/json; charset=utf-8');

$file = fopen("test.csv","r");
$f = [];
while(! feof($file))
{
    $a[] = fgetcsv($file);
}

fclose($file);
$urlEncodedWhiteSpaceChars   = '%81,%7F,%C5%8D,%8D,%8F,%C2%90,%C2,%90,%9D,%C2%A0,%A0,%C2%AD,%AD,%08,%09,%0A,%0D';
$temp = explode(',', $urlEncodedWhiteSpaceChars); // turn them into a temp array so we can loop across
foreach ($a as $array){
    foreach ($array as $d){
        $data  = urlencode($d);
        foreach($temp as $v){
            $data  =  str_replace($v, '', $data);     // replace the current char with Nothing
        }
        $s[] = urldecode($data); // undo the url_encode
    }
}

$file = fopen("new.csv","w");

foreach ($s as $line)
{
    fputcsv($file,explode(',',$line));
}

fclose($file);
