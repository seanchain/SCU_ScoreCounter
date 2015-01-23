<!DOCTYPE html>
<html>
<head lang="en">
  <meta charset="UTF-8">
  <title>成绩查询</title>
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
        window.location.href = "http://www.chensihang.com/register.html"
    }
    </script>
</head>
<body>
<div class="header">
  <div class="am-sans-serif">
    <h1>四川大学教务查分</h1>
  </div>
  <hr />
</div>
<div class="am-sans-serif">
  <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
    <br>
    <br>
    
    <ul class="am-nav am-nav-tabs">
        <li><a href="../index.php">首页</a></li>
        <li class="am-active"><a href="#">教务查分</a></li>
    </ul>
    
    <br /><br />
    
    <div class="am-panel am-panel-primary">
        <div class="am-panel-hd">教务处成绩查询</div>
        <div class="am-panel-bd">
            <form method="post" class="am-form" action="jwc.php">
                <label for="id">学号:</label>
                <input type="text" name="zjh" id="email" value="">
                <br>
                <label for="password">密码:</label>
                <input type="password" name="mm" id="password" value="">
                <br>
                <div class="am-form-group am-sans-serif">
                    <label for="doc-select-1">成绩查看方式</label>
                    <select id="doc-select-1" name="scorechecktype">
                        <option value="allsem">所有成绩查询</option>
                        <option value="thissem">本学期成绩查询</option>
                    </select>
                    <span class="am-form-caret"></span>
                </div>
                <br />
                <div class="am-cf">
                    <input type="submit" name="login_submit" value="点我查分^_^" class="am-btn am-btn-primary am-center">
                </div>
            </form>
        </div>
    </div>

    
      
      
      
    <hr>
  </div>
</div>
<h3 class="am-u-lg-6 am-u-md-8 am-u-sm-centered am-sans-serif">P.S.   此成绩查询系统仅针对四川大学^_^</h3>
</body>
</html>
