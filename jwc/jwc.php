<?php session_start(); ?>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>成绩结果</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="alternate icon" type="image/png" href="../assets/i/logo.png">
    <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
    <style>
    .header {
        text-align: center;
    }
    .header h1 {
        font-size: 200%;
        color: #333;
        margin-top: 30px;
    }
    .header p {
        font-size: 14px;
    }
    </style>
    <script>
    function to_register(){
        window.location.href = "./register.php"
    }
    </script>
</head>
<body>
    <div class="header">
        <div class="am-sans-serif">
            <h1>成绩结果</h1>
        </div>
        <hr />
    </div>
    <div class="am-sans-serif">
        <div class="am-u-lg-8 am-u-md-8 am-u-sm-centered">
            <br>
            <br>
            
            <ul class="am-nav am-nav-tabs">
                <li><a href="../index.php">首页</a></li>
                <li><a href="./index.php">成绩查询</a></li>
                <li class="am-active"><a href="#">查询结果</a></li>
            </ul>
            
            <br /><br />
            

<?php

include_once('simple_html_dom.php');

header("content-Type: text/html; charset=Utf-8"); 


function getPt($scores)
{
	if($scores >= 95){return 4;}
	else if($scores >= 90){return 3.8;}
	else if($scores >= 85){return 3.6;}
	else if($scores >= 80){return 3.2;}
	else if($scores >= 75){return 2.7;}
	else if($scores >= 70){return 2.2;}
	else if($scores >= 65){return 1.7;}
	else if($scores >= 60){return 1.0;}
	else return 0;
}

function getCookie($zjh, $mm)
{
    $login_url = 'http://202.115.47.141/loginAction.do';
    
    $postvar['zjh'] = $zjh;
    $postvar['mm'] = $mm;
    $cookie_file = tempnam('./temp','cookie');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $login_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvar);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_exec($ch);
    curl_close($ch);
    return $cookie_file;
}

function getName($cookie_file)
{
    $name_url = 'http://202.115.47.141/xjInfoAction.do?oper=xjxx';
    $name_ch = curl_init($name_url);
    curl_setopt($name_ch, CURLOPT_HEADER, 0);
    curl_setopt($name_ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($name_ch, CURLOPT_COOKIEFILE, $cookie_file);
    $name_contents = curl_exec($name_ch);
    curl_close($name_ch);
    $name_contents = mb_convert_encoding($name_contents, "utf8", "gb2312");
    $htmlparser1 = str_get_html($name_contents);
    $name_array = $htmlparser1->find('td[width=275]');
    $name_array1 = array();
    for($i = 0; $i < count($name_array); $i ++)
    {
        $temp = $name_array[$i]->plaintext;
        $name_array1[$i] = $temp;
    }
        
    $htmlparser1->clear();
    return $name_array1[1];
}


function getScoreAndPrintTable($send_url, $cookie_file, $type)
{
    $ch = curl_init($send_url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    
    $contents = curl_exec($ch);
    curl_close($ch);
    
    $contents = mb_convert_encoding($contents, "utf8", "gb2312");
    
    $htmlparser = str_get_html($contents);
    
    $body_array = $htmlparser->find('td[align=center]');
    
    
    $count = 0;
    
    $length = count($body_array);
    if($length == 0)
    {
        echo "<script>alert('输入账号或者密码错误！');</script>";
        echo "<script>window.location.href='./index.php'</script>";
        exit;
    }
    
    $j = 0;
    
    for($i = 0; $i < $length; $i ++)
    {
        $temp = $body_array[$i]->plaintext;
        if($i % 7 != 1 && $i % 7 != 3)
        {
            $printoutarr[$j] = $temp;
            $j ++;
        }
    }
    
    
    $sum = 0;
    $points = 0;
    $GPA_scores = 0;
    $GPA = 0;
    $avg = 0;
    $j = 0;
    $number = array();
    
    for ($i = 3; $i < count($printoutarr); $i += 5)
    {
        if(trim($printoutarr[$i]) == "必修")
        {
            $number[$j] = $printoutarr[$i - 1];
            $number[$j + 1] = $printoutarr[$i + 1];
            $j += 2;
        }
    }
    echo "<br >";
    $index = 0;
    while($index < count($number))
    {
        $sum += intval($number[$index]) * intval($number[$index + 1]);
        $GPA_scores += intval($number[$index])*getPt(intval($number[$index + 1]));
        $points += intval($number[$index]);
        $index += 2;
    }
    
    $avg = number_format($sum / $points, 2);
    $GPA = number_format($GPA_scores / $points, 2);
    
    
    $length = count($printoutarr); 
    $count = 0;
    $outputstr = '<meta charset="utf-8"><link rel="stylesheet" href="../assets/css/amazeui.min.css"/><style>
        .pdf{
            font-size:24px;
            text-align: center;
        }
    </style>';
    
        $header = '<div class="am-panel am-panel-default">
            <div class="pdf">'.
            getName($cookie_file).'的成绩单
            </div>
            <table class="am-table am-table-bordered am-table-radius am-table-striped am-u-sm-6 am-u-lg-centered"><tr>
                <td>课程号</td><td>课程名</td><td>学分</td><td>情况</td><td>成绩</td></tr>';
        echo '<div class="am-panel am-panel-success">
            <div class="am-panel-hd">欢迎您，'.
            getName($cookie_file).'
            </div>
            <table class="am-table am-table-bordered am-table-radius am-table-striped am-u-sm-6 am-u-lg-centered"><tr>
                <td>课程号</td><td>课程名</td><td>学分</td><td>情况</td><td>成绩</td></tr><tbody>';
        $outputstr = $outputstr.$header;
           
            for($i = 0; $i < $length; $i ++)
            {
                $count ++;
                if($count % 5 == 0)
                {
                    echo "<td>".$printoutarr[$i]."</td></tr>";
                    $outputstr = $outputstr."<td>".$printoutarr[$i]."</td></tr>";
                }
                else if($count % 5 == 1)
                {
                    echo "<tr><td>".$printoutarr[$i]."</td>";
                    $outputstr = $outputstr."<tr><td>".$printoutarr[$i]."</td>";
                    }
                    else {
                        echo "<td>".$printoutarr[$i]."</td>";
                        $outputstr = $outputstr."<td>".$printoutarr[$i]."</td>";
                    }
                }
                
                echo "</table>";
                $outputstr = $outputstr."</table>";
                
                if($type == 0)
                {
                    echo '</div><h3 class="am-u-sm-centered">加权平均分为'.$avg.'</h3>';
                    echo '<h3 class="am-u-sm-centered">GPA分数为'.$GPA.'</h3>';
                    $outputstr = $outputstr.'</div><br /><h3 class="am-u-sm-centered">加权平均分为'.$avg.'</h3>';
                    $outputstr = $outputstr.'<h3 class="am-u-sm-centered">GPA分数为'.$GPA.'</h3>';
                }
                
                echo '</div>';
                $outputstr = $outputstr.'</div><br /><br /><hr>';
    
                $_SESSION['filesaveData'] = $outputstr;
                
                $htmlparser->clear();
}

function getAllSemesters($cookie_file, $zjh)
{
    $send_url='http://202.115.47.141/gradeLnAllAction.do?type=ln&oper=sxinfo&lnsxdm=001#qb_001?type=ln&oper=sxinfo&lnsxdm=001#qb_001';
    getScoreAndPrintTable($send_url, $cookie_file, 0);
    printScoreResult($zjh);
}

function getThisSemester($cookie_file, $zjh)
{
    $send_url = "http://202.115.47.141/bxqcjcxAction.do";  
    getScoreAndPrintTable($send_url, $cookie_file, 1);
    printScoreResult($zjh);
}


function printScoreResult($zjh)
{
    echo '<form action="savePage.php" method="post">';
    echo '<input type="hidden" name="zjh" value="'.$zjh.'">';
    echo '<div align="center"><input type="submit" class="am-btn-primary am-round" value="存为PDF"></div>';
    echo '</form>'; 
    echo '<br /><br /><hr>';
}

/*set the option of the curl function */
$zjh = $_POST['zjh'];
$mm = $_POST['mm'];

$scorechecktype = $_POST['scorechecktype'];

$cookie = getCookie($zjh, $mm);


if($scorechecktype == 'allsem')
    getAllSemesters($cookie, $zjh);
else
    getThisSemester($cookie, $zjh);


unlink($cookie);
?>
