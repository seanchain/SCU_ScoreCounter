<?php
session_start();

function convert($filename, $zjh)
{
    $url = "www.chensihang.com/data/".$zjh.".html";
    $filename="../data/".$filename;
    exec("/usr/local/bin/wkhtmltopdf $url $filename");
/*    
    header('Content-Type: application/pdf');
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($filename));
    readfile("$filename");
 */
}


$zjh = $_POST['zjh'];

$filesaveData = $_SESSION['filesaveData'];
$filesaveDir = "../data/".$zjh.".html";
$file = fopen($filesaveDir, "w");
fputs($file, $filesaveData);
fclose($file);

echo "<meta charset=\"utf-8\">";
echo "<h1>正在生成您的PDF文件，请稍等</h1>";

$fn = $zjh."_score.pdf";

convert($fn, $zjh);

echo '<script>window.location.href="http://www.chensihang.com/data/'.$fn.'"</script>';

?>
