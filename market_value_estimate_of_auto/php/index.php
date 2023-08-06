<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>
    <header>
    <?php
    require_once 'header.php';
    ?>
    </header>
    <main>
        <div class="content">
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Инструкция</button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Как использовать калькулятор</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK</button>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div>
                <?php
                require_once 'bd.php';

                $sql1 = "select id, brand_name from brands";
                $result1 = mysqli_query($db, $sql1);
                $brands = "<option value=''>Выберите марку</option>";
                while ($row = mysqli_fetch_assoc($result1)) {
                    $brands .= "<option value='" . $row['brand_name'] . "'>" . $row['brand_name'] . "</option>";
                }

                $sql2="select id, model_name from models";
                $result2=mysqli_query($db, $sql2);
                $models="<option value=''>Выберите модель</option>";
                while ($row = mysqli_fetch_assoc($result2)) {
                    $models .= "<option value='" . $row['model_name'] . "'>" . $row['model_name'] . "</option>";
                }

                $sql3='select id, generation from generation';
                $result3=mysqli_query($db, $sql3);
                $generation="<option value=''>Выберите поколение</option>";
                while ($row = mysqli_fetch_assoc($result3)) {
                    $generation .= "<option value='" . $row['generation'] . "'>" . $row['generation'] . "</option>";
                }

                $sql4='select id, transm_type from transmission_types';
                $result4=mysqli_query($db, $sql4);
                $tr_type="<option value=''>Выберите тип КПП</option>";
                while ($row = mysqli_fetch_assoc($result4)) {
                    $tr_type .= "<option value='" . $row['transm_type'] . "'>" . $row['transm_type'] . "</option>";
                }

                $sql5='select id, wheel_drive_type from wheel_drive';
                $result5=mysqli_query($db, $sql5);
                $wheel_drive="<option value=''>Выберите тип привода</option>";
                while ($row = mysqli_fetch_assoc($result5)) {
                    $wheel_drive .= "<option value='" . $row['wheel_drive_type'] . "'>" . $row['wheel_drive_type'] . "</option>";
                }

                $sql6='select id, condition_description, wear from conditions';
                $result6=mysqli_query($db, $sql6);
                $condition="<option value=''>Выберите состояние</option>";
                while ($row = mysqli_fetch_assoc($result6)) {
                    $condition .= "<option value='" . $row['condition_description'] . "'>" . $row['condition_description'].'. Износ-'.$row['wear'].'%' . "</option>";
                }

                $sql7='select id, equipment from equipments';
                $result7=mysqli_query($db, $sql7);
                $equipment="<option value=''>Выберите комплектацию</option>";
                while ($row = mysqli_fetch_assoc($result7)) {
                    $equipment .= "<option value='" . $row['equipment'] . "'>" . $row['equipment'] . "</option>";
                }

                mysqli_close($db);
                ?>
                    <form action="" id="estimate_form" name="estimate_form">

                    <div class="form-group">
                        <label for="brand">Выберите :</label>

                        <select name="brand" id="brand" class="form-control"><?php echo $brands; ?></select>
                        <select name="model" id="model" class="form-control"><?php echo $models; ?></select>
                        <select name="generation" id="generation" class="form-control"><?php echo $generation; ?></select>
                        <select name="tr_type" id="tr_type" class="form-control"><?php echo $tr_type; ?></select>
                        <select name="wheel_drive" id="wheel_drive" class="form-control"><?php echo $wheel_drive; ?></select>
                        <select name="condition_description" id="condition_description" class="form-control"><?php echo $condition ?></select>
                        <select name="equipment" id="equipment" class="form-control"><?php echo $equipment; ?></select>

                        <input type="submit" class="btn btn-primary test" value="Рассчитать">
                    </div>

                    <div id="errorBlock" style="display: none; color: red;"></div>

                    </form>

                    <div>
                        <?php
                        $errorMessage = '';

                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            $fields = ['brand', 'model', 'generation', 'tr_type', 'wheel_drive', 'condition_description', 'equipment'];
                            $emptyFields = [];

                            foreach ($fields as $field) {
                                if (!isset($_GET[$field]) || empty($_GET[$field])) {
                                    $emptyFields[] = $field;
                                }
                            }

                            if (!empty($emptyFields)) {
                                $errorMessage = 'Ошибка: Пожалуйста, заполните все поля (' . implode(', ', $emptyFields) . ').';
                            } else {
                                require_once 'bd.php';
    
                            $brand = $_GET['brand'];
                            $model = $_GET['model'];
                            $generation = $_GET['generation'];
                            $trType = $_GET['tr_type'];
                            $wheelDrive = $_GET['wheel_drive'];
                            $conditionDescription = $_GET['condition_description'];
                            $equipment = $_GET['equipment'];

                            $sql = "SELECT AVG(price) AS avg_price 
                                    FROM cars 
                                    WHERE brand_id = (SELECT id FROM brands WHERE brand_name = '$brand')
                                    AND model_id = (SELECT id FROM models WHERE model_name = '$model')
                                    AND generation_id = (SELECT id FROM generation WHERE generation = '$generation')
                                    AND tr_id = (SELECT id FROM transmission_types WHERE transm_type = '$trType')
                                    AND wh_drive_id = (SELECT id FROM wheel_drive WHERE wheel_drive_type = '$wheelDrive')
                                    AND condition_id = (SELECT id FROM conditions WHERE condition_description = '$conditionDescription')";
                            
                            $result = mysqli_query($db, $sql);
                            
                            if ($result) {
                                $row = mysqli_fetch_assoc($result);
                                $averagePrice = $row['avg_price'];

                                
                                echo "Средняя стоимость автомобиля с выбранными параметрами: $averagePrice";
                            } else {
                                $errorMessage = 'Ошибка при выполнении запроса к базе данных.';
                            }

                            }
                        }
                        ?>
                    </div>

                </div>

        </div>
    </main>
    <footer>
    <?php
    
    ?>
    </footer>
    <script src="../scripts/validation.js"></script>
</body>
</html>