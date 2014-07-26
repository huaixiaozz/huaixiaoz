<?php
/**
 * 百度分享 For Typecho
 * 
 * @package BaiduShare
 * @author doudou
 * @version 1.0.1
 * @link http://doudou.me
 */
class BaiduShare_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer = array('BaiduShare_Plugin', 'render');
    }
    
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){
        $img_select = new Typecho_Widget_Helper_Form_Element_Radio('img', 
        array('0'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r0.gif">',
              '1'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r1.gif">',
              '2'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r2.gif">',
              '3'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r3.gif">',
              '4'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r4.gif">',
              '5'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r5.gif">',
              '6'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r6.gif">',
              '7'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r7.gif">',
              '8'=> '<img style="width:24px;height:88px;" src="http://bdimg.share.baidu.com/static/images/r8.gif">'
             ), 
        0, 
        _t('样式选择'),
        _t(''));
        $form->addInput($img_select);
        $pos_select = new Typecho_Widget_Helper_Form_Element_Radio('pos', 
        array('0'=> '右侧浮窗',
              '1'=> '左侧浮窗'
             ), 
        0, 
        _t('浮窗位置'),
        _t('推荐右侧浮窗'));
        $form->addInput($pos_select);
        $mode_select = new Typecho_Widget_Helper_Form_Element_Radio('mode', 
        array('0'=> '标准模式',
              '1'=> '迷你模式'
             ),
        0,
        _t('模式选择'),
        _t('迷你模式更加简洁'));
        $form->addInput($mode_select);
        $px_set = new Typecho_Widget_Helper_Form_Element_Text('px', NULL, '', _t('距离顶部位置'), _t('单位：px , 建议留空 , 会根据浏览器自适应位置<br/>相关链接：<a href="http://share.baidu.com/" target="_blank">百度分享</a>'));
        $form->addInput($px_set->addRule('isInteger', _t('仅限数字 , 请填写有效数值')));
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render()
    {
        $settings = Typecho_Widget::widget('Widget_Options')->plugin('BaiduShare');
        $position = $settings->pos ? '&amp;pos=left' : '';
        $mode = $settings->mode ? 'mini=1&amp;' : '';
        $config = $settings->px ? 'var bds_config = {"bdTop":' . $settings->px . '};' : '';
        echo "<script type=\"text/javascript\" id=\"bdshare_js\" data=\"type=slide&amp;" . $mode . "img=". $settings->img . $position ."\"></script>\n";
        echo "<script type=\"text/javascript\" id=\"bdshell_js\"></script>\n";
        echo "<script type=\"text/javascript\">" . $config;
        echo "document.getElementById(\"bdshell_js\").src = \"http://bdimg.share.baidu.com/static/js/shell_v2.js?t=\" + new Date().getHours();</script>\n";
    }
}