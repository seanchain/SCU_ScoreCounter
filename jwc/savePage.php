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

$fn = md5(sha1($zjh)).".pdf";

convert($fn, $zjh);
unlink($filesaveDir); //此时删除掉html文件

echo '<script>window.location.href="http://www.chensihang.com/data/'.$fn.'"</script>';

?>

