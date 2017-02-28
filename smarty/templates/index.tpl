<!doctype html>
<html lang="en-ru">
<head>
	<meta charset="utf-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="style.css">
	<title>Задание 6 Форма отправки объявления</title>
</head>
<body>
<div class="container">
	<h1>Подайте объявление:</h1>
	<form  method="post" id="add">
		{foreach from=$smarty_data.alert item=item}
			<p id="warning">{$item}</p>
        {/foreach}
        {html_radios name="type" options=$smarty_data.business_type selected=$ad.type}
		<fieldset class="contacts_email">
			<label>Ваше имя <input name="name" type="text" value="{$ad.name}" required></label><br/>
			<label>Ваш email <input name="email" type="text"  value="{$ad.email}" required></label><br/>
			{html_checkboxes name="confirm" options=$smarty_data.rss_confirm selected=$ad.confirm_rss}
		</fieldset>

		<fieldset class="contacts_location">
			<label>Ваш телефон <input name="phone" type="text" value="{$ad.phone}" required></label><br/>
			<label>Ваш город
                    {html_options name=city options=$smarty_data.cities selected=$ad.city}
			</label><br/>
			<label>Категория товара
					{html_options name=cat options=$smarty_data.cat selected=$ad.category}
			</label>
		</fieldset>

		<fieldset class="section_ad">
			<label>Заголовок обявления<input name="name_ad" type="text" value="{$ad.name_ad}" required></label><br/>
			<p>Текст объявления</p>
			<label><textarea name="ad_text" id="" cols="40" rows="10" required>{$ad.ad_text}</textarea></label><br/>
			<label id="price">Цена <input name="price" type="text" size="5" value="{$ad.price}"> <span>руб</span> </label><br/>
		</fieldset>
		<input type="submit" value="{$smarty_data.button_value}" class="buttons" name="add">
		<input type="hidden"  name="id" value="{$smarty_data.show_param}">
		<p id="notice">*Все поля обязательны для заполнения</p>
	</form>
        {include file ='show_table.tpl'}
</div> <!--End container -->
</body>
</html>