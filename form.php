<?php
if (isset ($_POST['1'])) {
	$to = "nick@printa.su";
	$from = "aidaprint.ru";
	$subject = "Заполнена контактная форма на сайте " . $_SERVER['HTTP_REFERER'];
	$message = "Название Компании (кратко, для имени БД): " . $_POST['1'] . "\
Количество сотрудников: " . $_POST['2'] . "\
Кто является основным клиентом: " . $_POST['3'] . "\n
Какие данные клиентов необходимо сохранить: " . $_POST['6'] . "\n
Где хранится текущая база клиентов: " . $_POST['8'] . "\n
Кто осуществляет перенос базы: " . $_POST['9'] . "\n
Какие каналы коммуникации использует компания: " . $_POST['11'] . " " . $_POST['14'] . "\n
Оператор ipтелефонии " . $_POST['111'] . "\n
Корпоративный e-mail: " . $_POST['15'] . "\n
Соцсети: " . $_POST['16'] . "\n
Корпоративный e-mail: " . $_POST['17'] . "\n
Мессенджеры: " . $_POST['18'] . "\n
Другое: " . $_POST['15'] . "\n
кто будет отвечать в каналах (Отделы, сотрудники): " . $_POST['19'] . "\n
Укажите кто будет предоставлять интегратору информацию о доступах к каналам связи (Контактное лицо, телефон, почта): " . $_POST['20'] . "\n
Какие этапы в процессе продаж важно контролировать (перечислите через запятую), например: Подготовка КП, Выставление счета, Создание сделки и т. д.: " . $_POST['21'] . "\n
Есть ли разделение зон ответственности в процессе продаж? Если да, то на каких этапах и между какими сотрудниками (отделами: " . $_POST['22'] . "\n
Какие документы используются в процессе продаж? Есть ли специфические документы (свои типы заявок, КП и т. д.): " . $_POST['23'] . "\n
Адрес сайта: " . $_SERVER['HTTP_REFERER'];

	$boundary = md5(date('r', time()));
	$filesize = '';
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "From: " . $from . "\r\n";
	$headers .= "Reply-To: " . $from . "\r\n";
	$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
	$message = "
Content-Type: multipart/mixed; boundary=\"$boundary\"
 
--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit
 
$message";
	if (is_uploaded_file($_FILES['getFile']['tmp_name'])) {
		$attachment = chunk_split(base64_encode(file_get_contents($_FILES['getFile']['tmp_name'])));
		$filename = $_FILES['getFile']['name'];
		$filetype = $_FILES['getFile']['type'];
		$filesize = $_FILES['getFile']['size'];
		$message .= "
 
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
	}

	if (is_uploaded_file($_FILES['getFile2']['tmp_name'][0])) {
		$attachment = chunk_split(base64_encode(file_get_contents($_FILES['getFile2']['tmp_name'][0])));
		$filename = $_FILES['getFile2']['name'][0];
		$filetype = $_FILES['getFile2']['type'][0];
		$filesize = $_FILES['getFile2']['size'][0];
		$message .= "
 
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
	}
	if (is_uploaded_file($_FILES['getFile2']['tmp_name'][1])) {
		$attachment = chunk_split(base64_encode(file_get_contents($_FILES['getFile2']['tmp_name'][1])));
		$filename = $_FILES['getFile2']['name'][1];
		$filetype = $_FILES['getFile2']['type'][1];
		$filesize = $_FILES['getFile2']['size'][1];
		$message .= "
 
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
	}
	if (is_uploaded_file($_FILES['getFile2']['tmp_name'][2])) {
		$attachment = chunk_split(base64_encode(file_get_contents($_FILES['getFile2']['tmp_name'][2])));
		$filename = $_FILES['getFile2']['name'][2];
		$filetype = $_FILES['getFile2']['type'][2];
		$filesize = $_FILES['getFile2']['size'][2];
		$message .= "
 
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
 
$attachment";
	}

	$message .= "

--$boundary--";
	if ($filesize < 10000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
		mail($to, $subject, $message, $headers);
	} else {
		echo 'Извините, письмо не отправлено. Размер всех файлов превышает 10 МБ.';
	}
}
