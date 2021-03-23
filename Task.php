<html>
	<head>
		<title>
			Задача
		</title>
	</head>
	<body>
		<?php
			$fileName = '\acess_log.txt'; //Название файла
			$filePath = 'D:\WebServers\home\localhost'.$fileName; // Путь к файлу
			$fileHandle = fopen($filePath, "r"); // Открываем файл в режиме "Для чтения"
			$logArray = array(array()); // Массив, в который попадут строки лога
			$result=array(); //Массив с результатами
			$urlsList = array(); //Список ссылок;
			$result["traffic"] = 0; //Траффик
			$result["post"] = 0; //Количество кодов отправки данных
			$result["get"] = 0; //Количество кодов получения данных
			$result["google"] = 0; //Счетчик гугл-ботов
			$result["bing"] = 0; //Счетчик бинг-ботов
			$result["baidu"] = 0; //Счетчик байду-ботов
			$result["yandex"] = 0; //Счетчик яндекс-ботов
			if ($fileHandle) //Если файл открылся
			{
				$counter = 0; //Переменная счетчик
				while (!feof($fileHandle)) //Пока не достигли конца файла выполняем тело
				{
					$string=fgets($fileHandle);
					if (stristr($string, 'googlebot') != FALSE)
					{
						$result["google"]++;
					} else if (stristr($string, 'bingbot') != FALSE)
					{
						$result["bing"]++;
					} else if (stristr($string, 'baidubot') != FALSE)
					{
						$result["baidu"]++;
					} else if (stristr($string, 'yandexbot') != FALSE)
					{
						$result["yandex"]++;
					}
					$logArray[$counter] = explode(" ", $string); //Записываем строку в counter-й элемент массива
					$urlsList[$logArray[$counter][6]] = 0; //Добавляем каждую уникальную ссылку как элемент массива
					echo $logArray[$counter][8], "<br/>";
					if ($logArray[$counter][8]==200) //Если код 200
					{
						$result["traffic"] = $result["traffic"] + $logArray[$counter][9]; //Считаем траффик
						$result["post"]++; //Увеличиваем его счетчик на 1
					} else 
					{
						$result["get"]++; //Увеличиваем счетчик 301 на 1
					}
					$counter++; //Увеличиваем индекс массива на 1 
				}
				$result["views"] = $counter; //Количество строк = количеству просмотров;
				$result["urls"] = count($urlsList); //Получаем количество уникальных ссылок в массиве
				//Выводим данные на экран
				echo "views: ", $result["views"], "<br/>";
				echo "urls: ", $result["urls"], "<br/>";
				echo "traffic: ", $result["traffic"], "<br/>";
				echo "crawlers : {", "<br/>";
				echo "Google: ", $result["google"], "<br/>";
				echo "Bing: ", $result["bing"], "<br/>";
				echo "Baidu: ", $result["baidu"], "<br/>";
				echo "Yandex: ", $result["yandex"], "<br/>";
				echo "}", "<br/>";
				echo "statusCodes: {", "<br/>";
				echo "200 : ", $result["post"], "<br/>";
				echo "301 : ", $result["get"], "<br/>";
				echo "}";
				$fileHandle = fclose($fileHandle); //Закрываем файл
			}
		?>
	</body>
</html>