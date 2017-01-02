<?php header('Content-Type: text/html; charset=WINDOWS-1251');

?>
<!doctype html>
<html lang="en-ru">
<head>
    <meta charset="WINDOWS-1251">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>������� 6 ����� �������� ����������</title>
</head>
<body>
<div class="container">
    <h1>������� ����������:</h1>
    <form  method="post" action="form_action.php">
        <fieldset class="radio">
            <label><input name="private" type="radio">������� ����</label>
            <label><input name="corp" type="radio">��������</label>
        </fieldset>

        <fieldset class="contacts_email">
            <label>���� ��� <input name="name" type="text"></label><br/>
            <label>��� email <input name="email" type="email"></label><br/>
            <label id="checkbox"><input name="confirm_rss" type="checkbox">� ���� �������� ������� �� ���������� �� email</label><br/>
        </fieldset>

        <fieldset class="contacts_location">
            <label>���� ��� <input name="phone" type="text"></label><br/>
            <label>��� �����
                <select  name="city">
                    <option disabled>�������� ��� �����</option>
                    <option selected value="�����������">�����������</option>
                    <option  value="������">������</option>
                    <option value="�����">�����</option>
                </select>
            </label><br/>
            <label>��������� ������
                <select  name="cat">
                    <option disabled>�������� ���������</option>
                    <option selected value="������� �������">������� �������</option>
                    <option  value="������ ��� ����">������ ��� ����</option>
                    <option value="������������ �������">������������ �������</option>
                </select>
            </label><br/>
        </fieldset>

        <fieldset class="section_ad">
            <label>��������� ���������<input name="name_add" type="text"></label><br/>
            <p>����� ����������</p>
            <label><textarea name="ad" id="" cols="50" rows="10"></textarea></label><br/>
            <label id="price">���� <input name="price" type="text" size="5"> <span>���</span></label><br/>
        </fieldset>
        <input type="submit" value="�������� ����������" class="buttons">
        <input type="button" value="������� ����������" class="buttons">
    </form>

    <h2>���� ����������: </h2>
        <?php var_dump($_POST); ?>
    <div id="ad_container">

    </div>
</div> <!--End container -->
</body>
</html>