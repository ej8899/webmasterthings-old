<?
// *******************************************************************
//  include/common.php
// *******************************************************************

$gl_sql = "
        select
                *
        from
                $tb_settings
        where
                ID='1'
";

$gl_query = sql_query($gl_sql);
$gl = sql_fetch_array($gl_query);

$validate = $gl["ManuallyValidate"];
$url_validate	 = $gl["URLValidate"];

$email_submission = $gl["NewSubmissionEmail"];
$email_deletion = $gl["SiteDeletionEmail"];
$email_addition = $gl["SiteAdditionEmail"];

$default_country = $gl["DefaultCountry"];

$colcount = $gl["ColCount"];
$pp = $gl["PerPage"];
$np = $gl["NavLinks"];

$base_path = $gl["BasePath"];
$base_url = $gl["BaseURL"];

$site_title = $gl["SiteTitle"];

$owner_name = $gl["Name"];
$owner_email = $gl["Email"];

$FormattedDate = $gl["DateFormat"];

$user_outer_frame = $gl["OuterFrame"];

$adm_body = "<body bgcolor=\"white\" text=\"black\" link=\"blue\" ";
$adm_body .= "alink=\"blue\" vlink=\"black\" marginheight=\"20\" ";
$adm_body .= "marginwidth=\"20\" topmargin=\"20\" leftmargin=\"20\">";

$menu_body = "<body class=\"menu\" bgcolor=\"white\" text=\"black\" link=\"blue\" ";
$menu_body .= "alink=\"blue\" vlink=\"black\" marginheight=\"0\" ";
$menu_body .= "marginwidth=\"0\" topmargin=\"0\" leftmargin=\"0\">";

$top_body = "<body bgcolor=\"white\" text=\"black\" link=\"black\" ";
$top_body .= "alink=\"blue\" vlink=\"black\" marginheight=\"2\" ";
$top_body .= "marginwidth=\"2\" topmargin=\"2\" leftmargin=\"2\">";

?>
