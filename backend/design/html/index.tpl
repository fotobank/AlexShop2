<!DOCTYPE html>
<!--[if IE 8]> <html lang="ru" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="ru" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ru" class="no-js">
<!--<![endif]-->
{*<!-- BEGIN HEAD -->*}
<head>
<meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8"/>
<meta HTTP-EQUIV = "Pragma" CONTENT = "no-cache">
<meta HTTP-EQUIV = "Expires" CONTENT = "-1">
<title>{$meta_title}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
	{*<!-- BEGIN GLOBAL MANDATORY STYLES -->*}
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css">
<link href="/backend/design/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="/backend/design/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
<link href="/backend/design/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/backend/design/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<link href="/backend/design/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
	{*<!-- END GLOBAL MANDATORY STYLES -->*}
	{*<!-- BEGIN THEME STYLES -->*}
<link href="/backend/design/assets/global/css/components.css" id="style_components" rel="stylesheet" type="text/css"/>
<link href="/backend/design/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
<link href="/backend/design/assets/admin/layout2/css/layout.css" rel="stylesheet" type="text/css"/>
<link id="style_color" href="/backend/design/assets/admin/layout2/css/themes/grey.css" rel="stylesheet" type="text/css"/>
<link href="/backend/design/assets/admin/layout2/css/custom.css" rel="stylesheet" type="text/css"/>
	{*<!-- END THEME STYLES -->*}
<link rel = "shortcut icon" href = "/backend/design/images/favicon.png">
</head>
{*<!-- END HEAD -->*}
{*<!-- BEGIN BODY -->*}
<body class="page-md page-boxed page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-sidebar-closed-hide-logo">
{*<!-- BEGIN HEADER -->*}
{if $smarty.get.module == "ProductAdmin"
|| $smarty.get.module == "CategoryAdmin"
|| $smarty.get.module == "BrandAdmin"
|| $smarty.get.module == "PostAdmin"
|| $smarty.get.module == "PageAdmin"}
	<script>
    $(window).on("load", function () {
        var title = $("input[name='meta_title']"),
            keywords = $("input[name='meta_keywords']"),
            desc = $("textarea[name='meta_description']");
        number = title.val().length;
        $(".count_title_symbol").html(number);
        $(".word_title").html(title.val().split(/[\s\.\?]+/).length);

        number = keywords.val().length;
        $(".count_keywords_symbol").html(number);
        $(".word_keywords").html(keywords.val().split(/[\s\.\?]+/).length);

        number = desc.text().length;
        $(".count_desc_symbol").html(number);
        $(".word_desc").html(desc.val().split(/[\s\.\?]+/).length);

        title.keyup(function count() {
            number = title.val().length;
            $(".count_title_symbol").html(number);
            total_words = $(this).val().split(/[\s\.\?]+/).length;
            $(".word_title").html(total_words);
        });
        keywords.keyup(function count() {
            number = keywords.val().length;
            $(".count_keywords_symbol").html(number);
            total_words = $(this).val().split(/[\s\.\?]+/).length;
            $(".word_keywords").html(total_words);
        });
        desc.keyup(function count() {
            number = desc.val().length;
            $(".count_desc_symbol").html(number);
            total_words = $(this).val().split(/[\s\.\?]+/).length;
            $(".word_desc").html(total_words);
        });

        $('input,textarea,select, a.delete').bind('keyup change click', function () {
            $('.fast_save').show();
        });

        $('.fast_save').on('click', function () {
            $('input[type=submit]').first().trigger('click');
        });
    });
</script>
{/if}
{*определяем текущий язык и id сессии*}
<script>
var current_lang = "{$lang_label}";
var session_id = "{$smarty.session.id}";
</script>
<a href = '{$config->root_url}/{$lang_link}' class = 'admin_bookmark'></a>
{*<!-- BEGIN HEADER INNER -->*}
{include file="header.tpl"}
{*<!-- END HEADER -->*}
<div class="container">
	{*<!-- BEGIN CONTAINER -->*}
	<div class="page-container">
        {*<!-- BEGIN SIDEBAR -->*}
        {include file="left.tpl"}
        {*<!-- END SIDEBAR -->*}
		{*<!-- BEGIN CONTENT -->*}
		<div class="page-content-wrapper">
			<div class="page-content">
				   {*<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->*}
                      {include file="configuration_modal_form.tpl"}
				   {*<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->*}
				   {*<!-- BEGIN STYLE CUSTOMIZER -->*}
                      {include file="customizer.tpl"}
				   {*<!-- END STYLE CUSTOMIZER -->*}
				{*<!-- BEGIN PAGE HEADER-->*}
				<h3 class="page-title">
				Blank Page <small>blank page</small>
				</h3>
                   {*НАЧАЛО ХЛЕБНЫЕ КРОШКИ*}
                   {include file="bread_crumbs.tpl"}
                   {*КОНЕЦ ХЛЕБНЫЕ КРОШКИ*}
				{*<!-- END PAGE HEADER-->*}
				{*<!-- BEGIN PAGE CONTENT-->*}
				<div class="row">
					<div class="col-md-12">
						 Page content goes here
                        {*{debug}*}
					</div>
				</div>
				{*<!-- END PAGE CONTENT-->*}
			</div>
		</div>
		{*<!-- END CONTENT -->*}
		{*<!-- BEGIN QUICK SIDEBAR -->*}
		{*<!--Cooming Soon...-->*}
		{*<!-- END QUICK SIDEBAR -->*}
	</div>
	{*<!-- END CONTAINER -->*}
	{*<!-- BEGIN FOOTER -->*}
	<div class="page-footer">
		<div class="page-footer-inner">
			 2017 &copy; AlexShop CMS. <a href="javascript:;" title="AlexShop CMS">AlexShop CMS</a>
		</div>
		<div class="scroll-to-top">
			<i class="icon-arrow-up"></i>
		</div>
	</div>
	{*<!-- END FOOTER -->*}
</div>
{*<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->*}
{*<!-- BEGIN CORE PLUGINS -->*}
<!--[if lt IE 9]>
<script src="/backend/design/assets/global/plugins/respond.min.js"></script>
<script src="/backend/design/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/backend/design/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
{*<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->*}
<script src="/backend/design/assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/backend/design/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
{*<!-- END CORE PLUGINS -->*}
<script src="/backend/design/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/backend/design/assets/admin/layout2/scripts/layout.js" type="text/javascript"></script>
<script src="/backend/design/assets/admin/layout2/scripts/demo.js" type="text/javascript"></script>
<script>
      jQuery(document).ready(function() {
          Metronic.init(); // init metronic core components
          Layout.init(); // init current layout
          Demo.init(); // init demo features
      });
   </script>
{*<!-- END JAVASCRIPTS -->*}
</body>
{*<!-- END BODY -->*}
</html>
