<?php
//include_once('/helper/krumo/krumo.class.php');
//include_once('/auth/auth_ssh.class.php');
// include_once('/var/vega.fcyb.mirea.ru/auth/auth_ssh.class.php');
include_once('auth_ssh.class.php');
//krumo($_COOKIE['hash']);

function printHeader($title = 'Вега - МИРЭА', $submenu = "", $styles = NULL, $scripts = NULL)
{
$au = new auth_ssh();
if(!@$_SESSION['sid'])
{
    session_start();
    $_SESSION['sid']='poniesRuleTheWorld';
}
$user = $au->loggedIn(@$_SESSION['hash']);    
?>
<html>
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="apple-touch-fullscreen" content="yes"/>
        <meta name="keywords" content="базовая кафедра, программное обеспечение, программные средства, прикладная математика, кибернетика, РТУ МИРЭА, РТУ, Российский технологический университет, радиоэлектронная аппаратура, АО Концерн радиостроения, Вега, Московский институт радиотехники электроники автоматики, МИРЭА, абитуриенты, студенты, аспиранты, преподаватели">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="/style/style.css" type="text/css" rel=stylesheet>
         <link href="/style/utils.css" type="text/css" rel=stylesheet>
        <script type="text/javascript" src="/disc_htm_files/roe.js"></script> 
	<title><?=$title?></title> 
<?php
    if(is_array($styles))
    {
        foreach($styles as $style)
        {
?>
        <link href="<?=$style?>" type="text/css" rel="stylesheet">
<?php
        }
    }

    if(is_array($scripts))
    {
        foreach($scripts as $script)
        {
?>
        <script type="text/javascript" src="<?=$script?>"></script>
<?php
        }
    }
?>
    </head>
    <body>
        <table class="body-table">
            <tr class="body-table-tr">
                <td rowspan="6" class="body-table-td-border"></td>                                                                                                               
                <td colspan="2" class="body-table-td" style="width: 531px; height: 164px; background-image: url(/images/h-c.png);">
                    <div class="image-text-block">
                        <a href="/index.php"><img style="width: 531px; height: 164px;" src="/images/h-l.png"></a>
                        <p class="image-text text-spec">Направление &laquo;Прикладная математика и информатика&raquo;</p>
                        <p class="image-text text-kaf">Кафедра программного обеспечения систем радиоэлектронной аппаратуры<br>
                        при АО &laquo;Концерн &laquo;Вега&raquo;</p>
                    </div>
                    
                </td> 
                <td colspan="2" rowspan="2" align="right" class="body-table-td" style="width: 531px; height: 234px; background-image: url(/images/h-c.png);">
                    <table cellpadding=0 cellspacing=0><tr><td valign=top style="width: 531px; height: 164px; background-image: url(/images/h-r.png);">
                    <!-- <div class="image-text-block"> -->
<?php
        if(!$user)
        {
?>
                    <form method="POST" enctype="multipart/form-data" action="/auth/action.php">
                        <p align="right" style="margin: 25; font-size: 13px; font-family: Arial Narrow,Trebuchet MS,Arial,Verdana,Tahoma;">
                        Логин&nbsp;<input class="flat-text" type="text" name="login" size=10><br>
                        Пароль&nbsp;<input class="flat-text" type="password" name="password" size=10><br>
                        <input type="submit" class="flat-button" value="Вход">
                        <input type="hidden" name="action" value="login">
                        </p>
                    </form>
<?php
        }
        else
        {
?>
                    <form method="POST" enctype="multipart/form-data" action="/auth/action.php">
                        <p align="right" style="margin: 25px; padding: 0 0 29px 0; font-size: 13px; font-family: Arial Narrow,Trebuchet MS,Arial,Verdana,Tahoma;">
                        <?=$user?><br>
                        <input type="submit" class="flat-button" value="Выход">
                        <input type="hidden" name="action" value="logout">
                        </p>
                    </form>
<?php
        }
?>

                        <p align="right" style="font-size: 13px; margin: -5px 25px 0px 0px; font-family: Arial Narrow,Trebuchet MS,Arial,Verdana,Tahoma;">
                        МИРЭА - <br>
                        Российский технологический университет<br>
                        Институт искусственного интеллекта</p>
                    <!-- </div> -->
                    </td></tr>
                    <tr><td style="width: 531px; height: 70px; background-image: url(/images/h-r2.png);"><img border=0 src="/images/h-r2.png">
                    </td></tr></table>
                </td>
                <td rowspan="6" class="body-table-td-border"></td>
            </tr>
            <tr class="body-table-tr">
                <td rowspan="3" class="body-table-td" style="width: 21px">&nbsp;</td> 
                <td colspan="1" class="body-table-td" valign=middle style="height: 70px; background-color: #ffffff;">
                    <div class="menu">
                        <a href="/about.php">О кафедре</a> | <a href="/appmath.php">О прикладной математике</a> | <a href="/disc.php">Дисциплины</a> | <a href="/vega.php">О Концерне</a> | <a href="/sitemap.php">Карта сайта</a> 
                    </div>
                    <?=$submenu?>
                </td>
            </tr>
            <tr class="body-table-tr"> 
                <td colspan="2" class="body-table-td" valign=middle style="height: 7px; background-color: #ffffff;"></td> 
                <td rowspan="2" class="body-table-td" style="width: 16px">&nbsp;</td>  
            </tr>
            <tr class="body-table-tr"> 
                <td colspan="2" valign=top class="body-table-td-content">
<?php
}

function printFooter()
{
    //<a href="mailto:lebedeva.sg@yandex.ru">Обратная связь</a>
?>
                </td>
                <td class="body-table-td" style="max-width: 16px; width: 16px;"></td> 
            </tr>
            <tr class="body-table-tr"> 
                <td colspan="4" class="body-table-td"  style="font-size: 14px; width: 1062px !important; height: 26px;">
                    
                    <div class="image-text-block" style="width: 100%;">
                    <table style="border-collapse: collapse; border-width: 0; width: 100% !important; height: 26px;">
                        <tr>
                            <td align="left" valign="middle" style="background-image: url(/images/f-c.png); width: 1032px; height: 26px; margin: 0; padding: 0;">
                                <img src="/images/f-l.png" alt="">    
                            </td>
                            <td align="right" valign="middle" style="background-image: url(/images/f-c.png); width: 30px; height: 26px; margin: 0; padding: 0;">
                                <img src="/images/f-r.png" alt="">
                            </td>
                        </tr>
                    </table>            
                        <p class="image-text text-email" style="width: 100%;">
                            &nbsp;&nbsp;<a href="mailto:vega@mirea.ru">Обратная связь</a>
                        </p>
                    </div>    
                </td>
            </tr>
            <tr class="body-table-tr">
                <td class="body-table-td" style="width: 21px;"></td>
                <td colspan="2" class="body-table-td-content">
                    <table align="center">
                        <tr class="body-table-tr"> 
                            <td class="body-table-td">
                                <!-- HotLog --> <script language="javascript"> hotlog_js="1.0"; hotlog_r=""+Math.random()+"&s=270979&im=134&r="+escape(document.referrer)+"&pg="+ escape(window.location.href); document.cookie="hotlog=1; path=/"; hotlog_r+="&c="+(document.cookie?"Y":"N"); </script>
                                <script language="javascript1.1"> hotlog_js="1.1";hotlog_r+="&j="+(navigator.javaEnabled()?"Y":"N")</script> 
                                <script language="javascript1.2"> hotlog_js="1.2"; hotlog_r+="&wh="+screen.width+'x'+screen.height+"&px="+ (((navigator.appName.substring(0,3)=="Mic"))? screen.colorDepth:screen.pixelDepth)</script> 
                                <script language="javascript1.3"> hotlog_js="1.3"</script> 
                                <script language="javascript">hotlog_r+="&js="+hotlog_js; document.write("<a href='https://click.hotlog.ru/?270979' target='_top'><img " + " src='https://hit10.hotlog.ru/cgi-bin/hotlog/count?"+ hotlog_r+"&' border=0 width=88 height=31 alt=HotLog></a>")</script> 
                                <noscript><a href="https://click.hotlog.ru/?270979" target=_top><img src="https://hit10.hotlog.ru/cgi-bin/hotlog/count?s=270979&im=134" border=0  width="88" height="31" alt="HotLog"></a></noscript> <!-- /HotLog --> 
                            </td> 
                            <td width="100%" class="body-table-td"> 
                                <div align="center" style="{font-family:Arial Narrow,Trebuchet MS,Arial,Verdana,Tahoma; font-size:12pt;}">
								<?php 
								if ($_SERVER['REQUEST_URI']=="/" || $_SERVER['REQUEST_URI']=="/index.php")
								{
								?>
									МОСКВА <?=date('Y', time())?>
								<?php
								}
								else
								{
								?>
									<a href="https://www.instagram.com/vega_mirea/"><img src="/images/nametag30.png"></a>
								<?php
								}
								?>
								</div> 
                            </td> 
                            <td class="body-table-td"> 
                                <!--Rating@Mail.ru COUNTER--><script language="JavaScript" type="text/javascript"><!-- 
                                 d=document;var a='';a+=';r='+escape(d.referrer); 
                                 js=10//--></script><script language="JavaScript1.1" type="text/javascript"><!-- 
                                 a+=';j='+navigator.javaEnabled(); 
                                 js=11//--></script><script language="JavaScript1.2" type="text/javascript"><!-- 
                                 s=screen;a+=';s='+s.width+'*'+s.height; 
                                 a+=';d='+(s.colorDepth?s.colorDepth:s.pixelDepth); 
                                 js=12//--></script><script language="JavaScript1.3" type="text/javascript"><!-- 
                                 js=13//--></script><script language="JavaScript" type="text/javascript"><!-- 
                                 d.write('<a href=\"https://top.mail.ru/jump?from=916242\"'+ 
                                 ' target=_top><img src=\"https://top.mail.ru/counter'+ 
                                 '?id=916242;t=216;js='+js+a+';rand='+Math.random()+ 
                                 '\" alt=\"Рейтинг@Mail.ru\"'+' border=0 height=31 width=88/><\/a>'); 
                                 if(11<js)d.write('<'+'!-- ')//--></script><noscript><a 
                                 target=_top href="https://top.mail.ru/jump?from=916242"><img 
                                 src="https://top.mail.ru/counter?js=na;id=916242;t=216" 
                                 border=0 height=31 width=88 
                                 alt="Рейтинг@Mail.ru"/></a></noscript><script language="JavaScript" type="text/javascript"><!-- 
                                 if(11<js)d.write('--'+'>')//--></script><!--/COUNTER--> 

                            </td> 
                        </tr> 
                    </table>
                </td>
                <td class="body-table-td" style="width: 16px;"></td>
            </tr>
        </table>
    </body>
</html>
<?php
}

function vHeader()
{
    printHeader();
}

function vutilster()
{
    printFooter();
}
?>