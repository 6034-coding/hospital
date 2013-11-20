<link type="text/css" href="/cui/view/images/guahao.css" rel="stylesheet" />
 <script type="text/javascript" src="/cui/view/images/guahao.js"></script>
 <div id="hnguahao">
 <form action="/cui/guahao.php?submit=1" method="post" id="gh_form">
 <h1>HIT校医院在线挂号系统</h1>
 <table cellpadding="0" cellspacing="0">
 <tbody>
 <tr class="tr1">
 <td width="100"><b>您的姓名：</b></td>
 <td><input type="text" class="text_s" name="name" id="gh_name" /></td>
 <td><u>*</u></td>
 </tr>
 <tr>
 <td><b>您的年龄：</b></td>
 <td><input type="text" class="text_s" name="age" id="gh_age" /></td>
 <td><u>*</u></td>
 </tr>
 <tr class="tr1">
 <td><b>您的性别：</b></td>
 <td>男士<input type="radio" name="sex" value="1" id="gh_sex" /> 女士<input type="radio" name="sex" value="0" /></td>
 <td><u>*</u></td>
 </tr>
 <tr>
 <td valign="top"><b>预约科室：</b></td>
 <td><select name="rid" id="gh_subject">
<option>外科</option>
<option>内科</option>
<option>骨科</option>
</select></td>
 <td><u>*</u></td>
 </tr>
 <tr class="tr1">
 <td><b>联系电话：</b></td>
 <td><input type="text" class="text_m" name="tel" id="gh_tel" /></td>
 <td><u>*</u></td>
 </tr>
 <tr>
 <td valign="top"><b>预约附言：</b></td>
 <td><textarea name="note" class="area_m" ></textarea></td>
 <td></td>
 </tr>
 <tr class="tr1">
 <td><b>来院时间：</b></td>
 <td><input onfocus="setday(this)" name="comedate" class="text_m" id="gh_comedate"></td>
 <td><u>*</u></td>
 </tr>
 <tr>
 <td><b>验证码：</b></td>
 <td><input type="text" class="text_s" name="yanzheng" id="gh_yanzheng" /> <img src="lib/yanzheng.php" /></td>
 <td><u>*</u></td>
 </tr>
 <tr class="tr1">
 <td colspan="3" align="center"><a href="javascript:submitForm();" class="submit"><img src="view/images/submit.gif" alt="" /></a></td>
 </tr>
 </tbody>
 </table>
 <p class="bot">HIT-Coding小组版权所有</p>
 </form>
 </div>
<?php require('config.php');?>
<?php include('lib/functions.php');?>
<?php require('lib/mysql.class.php');?>
<?php

@extract($_GET,EXTR_PREFIX_ALL,"g");
if(isset($_POST['submit']) || isset($g_submit)){
  @check_post_request();
  @extract($_POST,EXTR_PREFIX_ALL,"p");
}
session_cache_limiter('private,must-revalidate');
if(!isset($_SESSION)){
  session_start();
}
$config['sys']['path'] = str_replace('guahao.php','',$_SERVER['PHP_SELF']);

$db = new c_mysql;

if(isset($g_submit) || isset($p_submit)){
  if(empty($p_yanzheng))
    alert_back('很抱歉2，预约提交失败：验证码不正确，谢谢！');
  if($p_yanzheng != $_SESSION["Checknum"])
    alert_back('很抱歉，预约提交失败：验证码不正确，谢谢！');
  if(empty($p_name))
    alert_back('很抱歉，预约提交失败：请填写您的姓名，谢谢！');
  if(empty($p_age))
    alert_back('很抱歉，预约提交失败：请填写您的年龄，谢谢！');
  if($p_age < 0 || $p_age > 120)
    alert_back('很抱歉，预约提交失败：您输入的年龄不合法，请重新输入，谢谢！');
  if(empty($p_rid))
    alert_back('很抱歉，预约提交失败：请选择需要预约的科室，谢谢！');
  if(empty($p_tel))
    alert_back('很抱歉，预约提交失败：请填写您的联系电话，谢谢！');
  if(empty($p_comedate))
    alert_back('很抱歉，预约提交失败：请选择您的来院日期，谢谢！');
  if($p_comedate < date('Y-m-d'))
    alert_back('很抱歉，预约提交失败：请选择正确的来院日期，谢谢！');

  $date = array('name' => $p_name,
			  'age' => intval($p_age),
			  'gender' => $p_sex,
			  'rid' => $p_rid,
			  'tel' => $p_tel,
			  'date' => $p_comedate,
			  'note' => $p_note,
			  'addtime' => time());

  $result = $db->insert_date('record',$date);
  if(!$result)
    alert_back('添加预约失败，请稍后重试！');
  alert_back('添加预约成功，稍后我们将与您取得联系核实！');
}
exit();
?>