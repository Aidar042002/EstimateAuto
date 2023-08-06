<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/control.css">
</head>
<body>
    <header>
        <?php
            require_once 'header.php';
        ?>
    </header>
    <main class="center-content">
        <form action="" method="POST" name="addAuto">
            <label style="background-color: blue;">Добавление новых авто</label><br>
            <input type="text" name="brand" id="brand" placeholder="Марка"><br>
            <input type="text" name="model" id="model" placeholder="Модель"><br>
            <input type="text" name="generation" id="generation" placeholder="Поколение"><br>
            <input type="number" id="year" name="year" min="1901" max="2155" placeholder="Год выпуска" style="width: 189px;"><br><!-- ex.2000-->
            <input type="date" id="date" name="date" placeholder="Дата продажи" style="width: 189px;"><br>
            <input type="text" name="trType" id="trType" placeholder="Тип КПП"><br>
            <input type="number" name="volume" id="volume" placeholder="Объем двигателя" step="any"><br>
            <input type="number" name="power" id="power" placeholder="Л.с."><br>
            <input type="text" name="wheel" id="wheel" placeholder="Привод"><br>
            <input type="text" name="condition" id="condition" placeholder="Состояние"><br>
            <input type="number" name="price" id="price" placeholder="Цена"><br>
            <input type="text" name="eq" id="eq" placeholder="Комплектация"><br>
            <input type="number" name="mileage" id="mileage" placeholder="Пробег"><br>

            <input type="submit" value="Добавить">
        </form><br>
        <?php
            require_once 'bd.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $brand =trim($_POST["brand"]);
                $model = trim($_POST["model"]);
                $generation =trim($_POST["generation"]);
                $year = trim($_POST["year"]);
                $date = trim($_POST["date"]);
                $trType = trim($_POST["trType"]);
                $volume = trim($_POST["volume"]);
                $power = trim($_POST["power"]);
                $wheel = trim($_POST["wheel"]);
                $condition = trim($_POST["condition"]);
                $price = trim($_POST["price"]);
                $eq = trim($_POST["eq"]);
                $mileage=trim($_POST['mileage']);

                $sql = "INSERT INTO cars (auto_year, brand_id, condition_id, engine_volume, eq_id, generation_id, horse_power, model_id, price, sale_date, tr_id, wh_drive_id,mileage)
                        VALUES ('$year', (SELECT id FROM brand WHERE name = '$brand'), (SELECT id FROM condition WHERE name = '$condition'), '$volume', (SELECT id FROM eq WHERE name = '$eq'),
                        (SELECT id FROM generation WHERE name = '$generation'), '$power', (SELECT id FROM model WHERE name = '$model'), '$price', '$date', (SELECT id FROM tr WHERE name = '$trType'), (SELECT id FROM wh_drive WHERE name = '$wheel'),$mileage) ";
            
                if ($db->query($sql) === TRUE) {
                    echo "Данные успешно добавлены!";
                } else {
                    echo "Ошибка: " . $sql . "<br>" . $db->error;
                }
            }
            
            $db->close();
        ?>
    </main>
    <footer>
        
    </footer>
</body>
</html>