<?php
$web = require_once 'web.php';
error_reporting(0);
@header('Content-Type: text/html; charset=UTF-8');
$do=isset($_GET['do'])?$_GET['do']:'0';
if(file_exists('install.lock')){
    $installed=true;
    $do='0';
}

function checkfunc($f,$m = false) {
    if (function_exists($f)) {
        return '<font color="green">可用</font>';
    } else {
        if ($m == false) {
            return '<font color="black">不支持</font>';
        } else {
            return '<font color="red">不支持</font>';
        }
    }
}

function checkclass($f,$m = false) {
    if (class_exists($f)) {
        return '<font color="green">可用</font>';
    } else {
        if ($m == false) {
            return '<font color="black">不支持</font>';
        } else {
            return '<font color="red">不支持</font>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <title><?php echo $web['webname'] ?> - 安装向导</title>
    <meta name="author" content="nathan">
    <link rel="icon" href="favicon.ico" type="image/ico">
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <link href="static/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="static/css/style.min.css" rel="stylesheet">
    <style>
        .nathan_center{
            text-align: center;
        }
        .logo-header > img {
            margin: 100px 0;
            width: 210px;
            height: 36px;
        }
        .site-content {
            margin: 0 20%;
            width: 60%;
        }
        .auth-nav > a {
            margin-left: 5px;
        }
        @media (max-width: 769px) {
            .site-content {
                margin: 0;
                width: 100%;
            }
            .logo-header > img {
                margin: 20px 0;
            }
            .auth-nav > a {
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
<div class="lyear-layout-web">
    <div class="lyear-layout-container">
        <div class="logo-header text-center">
            <img src="<?php echo $web['logo'] ?>">
        </div>
        <div class="container-fluid site-content">
            <div class="card">
                <div class="card-body text-center auth-nav" style="padding: 32px 0;border-top: 5px solid #007bff;">
                    <a class="btn btn-danger" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $web['qq'] ?>&site=qq&menu=yes">联系作者</a>
                </div>
            </div>
            <div class="row">
                <?php if($do=='0'){?>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            <h4>安装说明</h4>
                        </div>
                        <div class="card-body">
                            <p><iframe src="readme.txt" class="form-control" style="width:100%;height:465px;"></iframe></p>
                            <?php if($installed){ ?>
                                <div class="alert alert-danger">您已经安装过，如需重新安装请删除install目录的<font color=red> install.lock </font>文件后再安装！</div>
                            <?php }else{?>
                                <p align="center"><a class="btn btn-danger btn-block" href="index.php?do=1">开始安装</a></p>
                            <?php }?>
                        </div>
                    </div>
                    <?php }elseif($do=='1'){?>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h4>环境检查</h4>
                            </div>
                            <div class="card-body">
                                <b>10%</b>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 10%">
                                    </div>
                                </div>
                                <br>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width:20%">函数检测</th>
                                        <th style="width:15%">需求</th>
                                        <th style="width:15%">当前</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>PHP 5.6+</td>
                                        <td>必须</td>
                                        <td><?php echo phpversion(); ?></td>
                                    </tr>
                                    <tr>
                                        <td>curl_exec()</td>
                                        <td>必须</td>
                                        <td><?php echo checkfunc('curl_exec',true); ?></td>
                                    </tr>
                                    <tr>
                                        <td>file_get_contents()</td>
                                        <td>必须</td>
                                        <td><?php echo checkfunc('file_get_contents',true); ?></td>
                                    </tr>
                                    </tbody>
                                </table><br>
                                <p><span><a class="btn btn-purple" href="index.php?do=0">上一步</a></span>
                                    <span style="float:right"><a class="btn btn-danger" href="index.php?do=2" align="right">下一步</a></span></p>
                            </div>

                            <?php }elseif($do=='2'){?>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h4>数据库配置</h4>
                                    </div>
                                    <div class="card-body">
                                        <b>30%</b>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                            </div>
                                        </div>
                                        <br>
                                        <?php
                                        if(defined("SAE_ACCESSKEY"))
                                            echo <<<HTML
检测到您使用的是SAE空间，支持一键安装，请点击 <a href="?do=3" class="btn btn-danger btn-block">下一步</a>
HTML;
                                        else
                                            echo <<<HTML
		<form action="?do=3" class="form-sign" method="post">
		<label for="name">数据库地址:</label>
		<input type="text" class="form-control" name="db_host" value="localhost">
		<label for="name">数据库端口:</label>
		<input type="text" class="form-control" name="db_port" value="3306">
		<label for="name">数据库用户名:</label>
		<input type="text" class="form-control" name="db_user" placeholder="请输入您的数据库用户名">
		<label for="name">数据库密码:</label>
		<input type="text" class="form-control" name="db_pwd" placeholder="请输入您的数据库密码">
		<label for="name">数据库名:</label>
		<input type="text" class="form-control" name="db_name" placeholder="请输入您的数据库名">
		<br><input type="submit" class="btn btn-danger btn-block" name="submit" value="保存配置">
		</form><br/>
		（如果已事先填写好config.php相关数据库配置，请 <a href="?do=3&jump=1">点击此处</a> 跳过这一步！）
HTML;
                                        ?>
                                    </div>
                                </div>

                                <?php }elseif($do=='3'){
                                ?>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header bg-info">
                                            <h4>保存数据库</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>50%</b>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                </div>
                                            </div>
                                            <br>
                                            <?php
                                            if(defined("SAE_ACCESSKEY") || $_GET['jump']==1){
                                                include_once '../config.php';
                                                if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']) {
                                                    echo '<div class="alert alert-info" role="alert">请先填写好数据库并保存后再安装</div><a class="btn btn-block btn-danger"  href="javascript:history.back(-1)">返回上一页</a>';
                                                } else {
                                                    if(!$con=mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port'])){
                                                        if(mysqli_connect_errno()==2002)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库地址填写错误！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        elseif(mysqli_connect_errno()==1045)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库用户名或密码填写错误！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        elseif(mysqli_connect_errno()==1049)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库名不存在！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        else
                                                            echo '<div class="alert alert-danger">连接数据库失败，['.mysqli_connect_errno().']'.mysqli_connect_error().'</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                    }elseif(version_compare(mysqli_get_server_info($con), '5.5.3', '<')){
                                                        echo '<div class="alert alert-danger">MySQL数据库版本太低，需要MySQL 5.6或以上版本！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                    }else{
                                                        echo '<div class="alert alert-success">数据库配置文件保存成功！</div>';
                                                        if(mysqli_query($con, "select * from config where 1")==FALSE)
                                                            echo '<p align="right"><a class="btn btn-primary btn-block" href="?do=4">创建数据表</a></p>';
                                                        else
                                                            echo '<div class="list-group-item list-group-item-info">系统检测到你已安装过'.$web['webname'].'</div>

				<div class="list-group-item">
					<a href="?do=6" class="btn btn-block btn-danger">跳过安装</a>
				</div>
				<div class="list-group-item">
					<a href="?do=4" onclick="if(!confirm(\'全新安装将会清空所有数据，是否继续？\')){return false;}" class="btn btn-block btn-warning">强制全新安装</a>
				</div>';
                                                    }
                                                }
                                            }else{
                                                $db_host=isset($_POST['db_host'])?$_POST['db_host']:NULL;
                                                $db_port=isset($_POST['db_port'])?$_POST['db_port']:NULL;
                                                $db_user=isset($_POST['db_user'])?$_POST['db_user']:NULL;
                                                $db_pwd=isset($_POST['db_pwd'])?$_POST['db_pwd']:NULL;
                                                $db_name=isset($_POST['db_name'])?$_POST['db_name']:NULL;

                                                if($db_host==null || $db_port==null || $db_user==null || $db_pwd==null || $db_name==null){
                                                    echo '<div class="alert alert-info" role="alert">保存错误,请确保每项都不为空</div><a class="btn btn-block btn-danger"  href="javascript:history.back(-1)">返回上一页</a>';
                                                } else {
                                                    $config="<?php
/*数据库配置*/
\$dbconfig=array(
	'host' => '{$db_host}', //数据库服务器
	'port' => '{$db_port}', //数据库端口
	'user' => '{$db_user}', //数据库用户名
	'pwd' => '{$db_pwd}', //数据库密码
	'dbname' => '{$db_name}' //数据库名
);
?>";
                                                    if(!$con=mysqli_connect($db_host,$db_user,$db_pwd,$db_name,$db_port)){
                                                        if(mysqli_connect_errno()==2002)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库地址填写错误！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        elseif(mysqli_connect_errno()==1045)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库用户名或密码填写错误！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        elseif(mysqli_connect_errno()==1044)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库名填写错误！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        elseif(mysqli_connect_errno()==1049)
                                                            echo '<div class="alert alert-danger">连接数据库失败，数据库名不存在！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                        else
                                                            echo '<div class="alert alert-danger">连接数据库失败，['.mysqli_connect_errno().']'.mysqli_connect_error().'</div>';
                                                    }elseif(version_compare(mysqli_get_server_info($con), '5.5.3', '<')){
                                                        echo '<div class="alert alert-danger">MySQL数据库版本太低，需要MySQL 5.6或以上版本！</div>';
                                                    }elseif(file_put_contents('../config.php',$config)){
                                                        if(function_exists("opcache_reset"))@opcache_reset();
                                                        echo '<div class="alert alert-success">数据库配置文件保存成功！</div>';
                                                        if(mysqli_query($con, "select * from config where 1")==FALSE)
                                                            echo '<p align="right"><a class="btn btn-primary btn-block" href="?do=4">创建数据表</a></p>';
                                                        else
                                                            echo '<div class="list-group-item list-group-item-info">系统检测到你已安装过'.$web['webname'].'</div>
				<div class="list-group-item">
					<a href="?do=6" class="btn btn-block btn-danger">跳过安装</a>
				</div>
				<div class="list-group-item">
					<a href="?do=4" onclick="if(!confirm(\'全新安装将会清空所有数据，是否继续？\')){return false;}" class="btn btn-block btn-warning">强制全新安装</a>
				</div>';
                                                    }else
                                                        echo '<div class="alert alert-info" role="alert">保存失败，请确保网站根目录有写入权限<a class="btn btn-block btn-danger" href="javascript:history.back(-1)">返回上一页</a></div>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php }elseif($do=='4'){?>
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header bg-info">
                                                <h4>创建数据表</h4>
                                            </div>
                                            <div class="card-body">
                                                <b>70%</b>
                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                                    </div>
                                                </div>
                                                <br>
                                                <?php
                                                include_once '../config.php';
                                                if(!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']) {
                                                    echo '<div class="alert alert-info" role="alert">请先填写好数据库并保存后再安装！</div><a class="btn btn-block btn-danger" href="javascript:history.back(-1)"> 返回上一页</a>';
                                                } else {
                                                    $sql=file_get_contents("install.sql");
                                                    $sql=explode(';',$sql);
                                                    $cn = mysqli_connect($dbconfig['host'],$dbconfig['user'],$dbconfig['pwd'],$dbconfig['dbname'],$dbconfig['port']);
                                                    if (!$cn) die('err:'.mysqli_connect_error());
                                                    mysqli_query($cn, "set sql_mode = ''");
                                                    mysqli_query($cn, "set names utf8");
                                                    $t=0; $e=0; $error='';
                                                    for($i=0;$i<count($sql);$i++) {
                                                        if ($sql[$i]=='')continue;
                                                        if(mysqli_query($cn, $sql[$i])) {
                                                            ++$t;
                                                        } else {
                                                            ++$e;
                                                            $error.=mysqli_error($cn).'<br/>';
                                                        }
                                                    }
                                                }
                                                if($e==0) {
                                                    echo '<div class="alert alert-success">安装成功！<br/>SQL成功'.$t.'句/失败'.$e.'句</div><p align="right"><a class="btn btn-block btn-danger" href="index.php?do=5">下一步</a></p>';
                                                } else {
                                                    echo '<div class="alert alert-danger">安装失败<br/>SQL成功'.$t.'句/失败'.$e.'句<br/>错误信息：'.$error.'</div><p align="right"><a class="btn btn-block btn-danger" href="index.php?do=4">点此进行重试</a></p>';
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <?php }elseif($do=='5'){?>
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-header bg-info">
                                                    <h4>安装完成</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>100%</b>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <?php
                                                    @file_put_contents("install.lock",'友情提示：这个文件是安装锁哦');
                                                    echo '<div class="alert alert-info"><font color="green">安装完成！<br>管理员账号是：admin<br>管理员密码是：123456</font><br/><br/><a class="btn  btn-danger" href="../">网站首页</a>｜<a class="btn btn-danger" href="../admin/">后台管理</a><hr/>更多设置选项请登录后台管理进行修改。<br/><br/><font color="#FF0033">如果你的空间不支持本地文件读写，请自行在网站install目录建立 install.lock 文件！</font></div>';
                                                    ?>
                                                </div>
                                            </div>

                                            <?php }elseif($do=='6'){?>
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header bg-info">
                                                        <h4>安装完成</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <b>100%</b>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <?php
                                                        @file_put_contents("install.lock",'友情提示：这个文件是安装锁哦');
                                                        echo '<div class="alert alert-info"><font color="green">安装完成！<br>管理员账号是：admin<br>管理员密码是：123456</font><br/><br/><a class="btn  btn-danger" href="../">网站首页</a>｜<a class="btn btn-danger" href="../admin/">后台管理</a><hr/>更多设置选项请登录后台管理进行修改。<br/><br/><font color="#FF0033">如果你的空间不支持本地文件读写，请自行在网站install目录建立 install.lock 文件！</font></div>';
                                                        ?>
                                                    </div>
                                                </div>

                                                <?php }?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-footer nathan_center">
                            <p class="copyright">Copyright &copy; <?php echo date('Y') ?>. <a target="_blank" href=""><?php echo $web['webname'] ?></a> All right reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>