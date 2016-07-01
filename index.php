<!DOCTYPE html>
<html>
<head>
	<title>Check robots.txt</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="styles/main.css" /> 
</head>

<body>
	<div>
	<form action="" method="post">
	<label>Введите адрес сайта:</label>
	<input type="url" value="http://" name="url"><br>
	<input type="submit">
	</form>
	</div>
	<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
	$url=$_POST['url']."/robots.txt";
	
	echo '<table>';
	echo "<tr id='title'>";
	echo '<td>№</td>';
	echo '<td>Название проверки</td>';
	echo '<td>Статус</td>';
	echo '<td></td>';
	echo '<td>Текущее состояние</td>';
	echo '</tr>';
	
//check 1
	echo '<tr>';
	echo '<td rowspan="2">1</td>';
	echo '<td rowspan="2">Проверка наличия файла robots.txt</td>';
	$header_response = get_headers($url, 1);
	if ( strpos( $header_response[0], "404" ) !== false )
	{
		echo "<td rowspan='2' id='wrong'>"."Ошибка"."<br></td>";
		echo '<td>Состояние</td>';
		echo '<td>Файл robots.txt отсутствует.</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Рекомендации</td>';
		echo '<td>Программист: Создать файл robots.txt и разместить его на сайте.</td>';

	}
	else
	{
		echo "<td rowspan='2' id='right'>"."Ок"."<br></td>";
		echo '<td>Состояние</td>';
		echo '<td>Файл robots.txt присутствует.</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Рекомендации</td>';
		echo '<td>Доработки не требуются.</td>';
		
//check 6
		echo '<tr>';
		echo '<td rowspan="2">6</td>';
		echo '<td rowspan="2">Проверка указания директивы Host</td>';
		if( strpos(file_get_contents($url),"Host:") !== false) {
			
			echo "<td rowspan='2' id='right'>"."Ок"."<br></td>";
			echo '<td>Состояние</td>';
			echo '<td>Директива Host указана.</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Рекомендации</td>';
			echo '<td>Доработки не требуются.</td>';
			
//check 8
			echo '<tr>';
			echo '<td rowspan="2">8</td>';
			echo '<td rowspan="2">Проверка количества директив Host, прописанных в файле</td>';
			if (mb_substr_count(file_get_contents($url), "Host:")>1)
			{
				echo "<td rowspan='2' id='wrong'>"."Ошибка"."<br></td>";
				echo '<td>Состояние</td>';
				echo '<td>В файле прописано несколько директив Host.</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Рекомендации</td>';
				echo '<td>Программист: Директива Host должна быть указана в файле толоко 1 раз. 
				Необходимо удалить все дополнительные директивы Host и оставить только 1, 
				корректную и соответствующую основному зеркалу сайта.</td>';
				
			}
			else { 
				echo "<td rowspan='2' id='right'>"."Ок"."<br></td>";
				echo '<td>Состояние</td>';
				echo '<td>В файле прописана 1 директива Host.</td>';
				echo '</tr>';
				echo '<tr>';
				echo '<td>Рекомендации</td>';
				echo '<td>Доработки не требуются.</td>';
			}
		}
		else 
		{ echo "<td rowspan='2' id='wrong'>"."Ошибка"."<br></td>";
			echo '<td>Состояние</td>';
			echo '<td>В файле robots.txt не указана директива Host.</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Рекомендации</td>';
			echo '<td>Программист: Для того, чтобы поисковые системы знали, 
			какая версия сайта является основных зеркалом, 
			необходимо прописать адрес основного зеркала в 
			директиве Host. В данный момент это не прописано. 
			Необходимо добавить в файл robots.txt директиву Host. 
			Директива Host задётся в файле 1 раз, после всех 
			правил.</td>';
		}
		
//check 11
		echo '<tr>';
		echo '<td rowspan="2">11</td>';
		echo '<td rowspan="2">Проверка указания директивы Sitemap</td>';
		if( strpos(file_get_contents($url),"Sitemap:") !== false) {
			echo "<td rowspan='2' id='right'>"."Ок"."<br></td>";
			echo '<td>Состояние</td>';
			echo '<td>Директива Sitemap указана.</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Рекомендации</td>';
			echo '<td>Доработки не требуются.</td>';
		}
		else {
			echo "<td rowspan='2' id='wrong'>"."Ошибка"."<br></td>";
			echo '<td>Состояние</td>';
			echo '<td>В файле robots.txt не указана директива Sitemap</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Рекомендации</td>';
			echo '<td>Программист: Добавить в файл robots.txt директиву Sitemap.</td>';
		}
		
//check 10
		echo '<tr>';
		echo '<td rowspan="2">10</td>';
		echo '<td rowspan="2">Проверка размера файла robots.txt</td>';
		$size=strlen(file_get_contents($url))/1024;
		if($size <=32)
		{
			echo "<td rowspan='2' id='right'>"."Ок"."<br></td>";
			echo '<td>Состояние</td>';
			echo '<td>Размер файла robots.txt составляет '.$size.' Кб,
		что находится в пределах допустимой нормы.</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Рекомендации</td>';
			echo '<td>Доработки не требуются.</td>';
		}
		else
		{
			echo "<td rowspan='2' id='wrong'>"."Ошибка"."<br></td>";
			echo '<td>Состояние</td>';
			echo '<td>Размера файла robots.txt составляет'.$size.' Кб, что превышает допустимую норму.</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Рекомендации</td>';
			echo '<td>Программист: Максимально допустимый размер файла robots.txt составляем 32 кб.
		Необходимо отредактировть файл robots.txt таким образом,
		чтобы его размер не превышал 32 Кб.</td>';
		}
	}
	
//check 12
	echo '<tr>';
	echo '<td rowspan="2">12</td>';
	echo '<td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>';
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
	curl_setopt($ch, CURLOPT_NOBODY, true);    // we don't need body
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_TIMEOUT,10);
	$output = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	if ( strpos( $header_response[0], "200" ) !== false )
	{
		echo "<td rowspan='2' id='right'>"."Ок"."<br></td>";
		echo '<td>Состояние</td>';
		echo '<td>Файл robots.txt отдаёт код ответа сервера 200.</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Рекомендации</td>';
		echo '<td>Доработки не требуются.</td>';
	}
	else
	{
		echo "<td rowspan='2' id='wrong'>"."Ошибка"."<br></td>";
		echo '<td>Состояние</td>';
		echo '<td>При обращении к файлу robots.txt сервер возвращает код ответа '.$httpcode.'</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>Рекомендации</td>';
		echo '<td>Программист: Файл robots.txt должны отдавать код ответа 200, 
		иначе файл не будет обрабатываться. Необходимо настроить сайт 
		таким образом, чтобы при обращении к файлу sitemap.xml 
		сервер возвращает код ответа 200.</td>';
	}
	echo '</table>';
	}
?>
</body>
</html>

