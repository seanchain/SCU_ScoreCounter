<?php
session_start();

function convert($filename, $zjh)
{
    $url = "www.chensihang.com/data/".$zjh.".html";
    $filename="../data/".$filename;
    exec("/usr/local/bin/wkhtmltopdf $url $filename");
}


$zjh = $_POST['zjh'];

$filesaveData = $_SESSION['filesaveData'];
$filesaveDir = "../data/".$zjh.".html";
$file = fopen($filesaveDir, "w");
fputs($file, $filesaveData);
fclose($file);

echo "<meta charset=\"utf-8\">";
echo "<h1>正在生成您的PDF文件，请稍等</h1>";

$fn = sha1($zjh)."_score.pdf";

convert($fn, $zjh);
unlink($filesaveDir); //此时删除掉html文件

echo '<script>window.location.href="http://www.chensihang.com/data/'.$fn.'"</script>';

?>
