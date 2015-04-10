<?php
session_start();

function convert($filename, $zjh)
{
    $url = "www.chensihang.com/data/".$zjh.".html";
    $filename="../data/".$filename;
    exec("/usr/local/bin/wkhtmltopdf $url $filename");
}


function request_by_curl($remote_server,$post_string){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$remote_server);
    curl_setopt($ch,CURLOPT_POSTFIELDS,'mypost='.$post_string);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_USERAGENT,"Jimmy's CURL Example beta");
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}


$zjh = $_POST['zjh'];

$filesaveData = $_SESSION['filesaveData'];
$filesaveDir = "../data/".$zjh.".html";
$file = fopen($filesaveDir, "w");
fputs($file, $filesaveData);
fclose($file);

echo "<meta charset=\"utf-8\">";
echo "<h1>正在生成您的PDF文件，请稍等</h1>";

$fn = $zjh.".pdf";

convert($fn, $zjh);
unlink($filesaveDir); //此时删除掉html文件

$file_url = 'http://www.chensihang.com/data/'.$fn;
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"" . basename($file_url) . "\"");
readfile($file_url); // do the double-download-dance (dirty but worky)
$file_pdf = "../data/".$zjh.".pdf";
unlink($file_pdf);

?>

