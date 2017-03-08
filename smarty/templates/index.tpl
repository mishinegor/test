<!doctype html>
<html lang="en-ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<!-- Bootstrap -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


	<link rel="stylesheet" href="style.css">
	<title>Задание 6 Форма отправки объявления</title>
</head>
<body>
<div class="container form-group">
	<h1>Подайте объявление:</h1>
	<form  method="post" id="add">
		{foreach from=$smarty_data.alert item=item}
			<p id="warning" class="help-block">{$item}</p>
        {/foreach}
        {html_radios name="type" options=$smarty_data.business_type selected=$ad.type}
		<fieldset class="contacts_email form-group">
			<label>Ваше имя <input name="name" type="text" class="form-control" value="{$ad.name}" required></label><br/>
			<label>Ваш email <input name="email" type="text" class="form-control" value="{$ad.email}" required></label><br/>
			{html_checkboxes name="confirm" options=$smarty_data.rss_confirm selected=$ad.confirm_rss}
		</fieldset>

		<fieldset class="contacts_location">
			<label>Ваш телефон <input name="phone" type="text" value="{$ad.phone}" class="form-control" required></label><br/>
			<label>Ваш город
                    {html_options name=city options=$smarty_data.cities selected=$ad.city class="form-control"}
			</label><br/>
			<label>Категория товара
					{html_options name=cat options=$smarty_data.cat selected=$ad.category class="form-control"}
			</label>
		</fieldset>

		<fieldset class="section_ad">
			<label>Заголовок обявления<input name="name_ad" type="text" class="form-control" value="{$ad.name_ad}" required></label><br/>
			<p>Текст объявления</p>
			<label><textarea name="ad_text" class="form-control" cols="40" rows="10" required>{$ad.ad_text}</textarea></label><br/>
			<label id="price">Цена <input name="price" type="text" size="5" class="form-control" value="{$ad.price}"> <span>руб</span> </label><br/>
		</fieldset>
		<input type="submit" value="{$smarty_data.button_value}" class="btn btn-primary" name="add">
		<input type="hidden"  name="id" value="{$smarty_data.show_param}">
		<p class="help-block">*Все поля обязательны для заполнения</p>
	</form>
        {include file ='show_table.tpl'}
</div> <!--End container -->
</body>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>