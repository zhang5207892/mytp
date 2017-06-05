<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv=content-type content="text/html; charset=utf-8" />
        <link href="/Public/Admin/Css/admin.css" type="text/css" rel="stylesheet" />
        <script language=javascript>
            function expand(el)
            {
                childobj = document.getElementById("child" + el);

                if (childobj.style.display == 'none')
                {
                    childobj.style.display = 'block';
                }
                else
                {
                    childobj.style.display = 'none';
                }
                return;
            }
        </script>
    </head>
    <body>
        <table height="100%" cellspacing=0 cellpadding=0 width=170 
               background=/Public/Admin/Img/menu_bg.jpg border=0>
               <tr>
                <td valign=top align=middle>
                    <table cellspacing=0 cellpadding=0 width="100%" border=0>

                        <tr>
                            <td height=10></td></tr>
        </table>

                <!-- 权限菜单 start-->
                <?php $menu = session('menu'); foreach ($menu as $k => $v): ?>
                    <table cellspacing=0 cellpadding=0 width=150 border=0>
                        <tr height=22>
                            <td style="padding-left: 30px" background=/Public/Admin/Img/menu_bt.jpg><a class=menuparent onclick=expand(<?php echo $k;?>)
                                    href="javascript:void(0);"><?php echo $v['auth_name'];?></a></td></tr>
                        <tr height=4>
                            <td></td></tr>
                    </table>
                    <table id=child<?php echo $k;?> style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                      <!-- 子级权限 start-->
                      <?php foreach ($v['sub'] as $k1 => $v1): ?>
                        <tr height=20>
                            <td align=middle width=30>
                              <img height=9 src="/Public/Admin/Img/menu_icon.gif" width=9>
                            </td>
                            <td><a class=menuchild href="<?php echo U($v1['auth_controller'] .'/'.$v1['auth_action']);?>" target='right'><?php echo $v1['auth_name'];?></a></td>
                        </tr>

                      <?php endforeach ?>
                      <!-- 子级权限 end-->

                    </table>

                <?php endforeach ?>

            <!-- 权限菜单 end-->


                    <table id=child0 style="display: none" cellspacing=0 cellpadding=0 
                           width=150 border=0>

                        <tr height=20>
                            <td align=middle width=30><img height=9 
                                                           src="/Public/Admin/Img/menu_icon.gif" width=9></td>
                            <td><a class=menuchild 
                                   href="#" 
                                   target=main>修改口令</a></td></tr>
                        <tr height=20>
                            <td align=middle width=30><img height=9 
                                                           src="/Public/Admin/Img/menu_icon.gif" width=9></td>
                            <td><a class=menuchild 
                                   onclick="if (confirm('确定要退出吗？')) return true; else return false;" 
                                   href="http://www.865171.cn" 
                                   target=_top>退出系统</a></td></tr></table></td>
                <td width=1 bgcolor=#d1e6f7></td>
            </tr>
        </table>
    </body>
</html>