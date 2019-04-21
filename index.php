<?
require_once 'DB.php';
require 'vendor/autoload.php';
require 'MyReadFilter.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;

$db = new DB();

$model_column_name = $db->getRows('SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?;', ['parserdb', 'valueparser']);
$count_column_name = count($model_column_name);

try {
    $inputFileType = 'Xls';
    $inputFileName = 'parser.xls';
    $sheetname = 'остатки и цены 13102017';

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
    $reader->setLoadSheetsOnly($sheetname);
    $reader->setReadFilter( new MyReadFilter(1,1,range('A','D')) );
    $spreadsheet = $reader->load($inputFileName);
    $cells = $spreadsheet->getActiveSheet()->getCellCollection();
    $k = 0;
    for ($row = 1; $row <= $cells->getHighestRow(); $row++){
        for ($col = 'A'; $col <= 'D'; $col++) {
            $value =  $cells->get($col.$row)->getValue();
            $arNameColomn[$k]['ID']=$col;
            $arNameColomn[$k]['VALUE']=$value;
            $k++;
        }
    }
} catch(\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
    die('Error loading file: '.$e->getMessage());
}
?>
<?// echo "<pre>"; print_r($arNameColomn); echo "</pre>";?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Парсер</title>
</head>
<body>
<header>
    <div class="container">
        <h1>
            Парсер
        </h1>
    </div>
</header>
<main>
    <section>
        <div class="container">
            <? if ($model_column_name && $arNameColomn): ?>
                <form action="parser.php" method="post">
                    <? for ($i = 0; $i < $count_column_name - 1; $i++): ?>
                        <div class="form-group">
                            <label for="">
                                Выберете соотвествие:
                            </label>
                            <div class="row">
                                <div class="col">
                                    <label for="">
                                        Выбирете поле модели
                                    </label>
                                    <select name="model-name_<?=$i;?>" class="form-control model-name" data-id="<?=$i;?>">
                                        <? foreach ($model_column_name as $key=>$name): ?>
                                            <option value="<?=($key==0)? '0': $name['COLUMN_NAME']?>"><?=($key==0)? '': $name['COLUMN_NAME']?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="">
                                        Выбирете номер колонки
                                    </label>
                                    <select name="column-name_<?=$i;?>" class="form-control column-name" data-id="<?=$i;?>">
                                        <option value="0"></option>
                                        <? foreach ($arNameColomn as $name): ?>
                                            <option value="<?=$name['ID']?>"><?=$name['VALUE']?></option>
                                        <? endforeach; ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    <? endfor; ?>
                    <div class="form-group">
                        <label for="">
                            Выберете дипазон строк:
                        </label>
                        <div class="row">
                            <div class="col">
                                <label for="">
                                    Введите номер строки для старта
                                </label>
                                <input type="number" name="start">
                            </div>
                            <div class="col">
                                <label for="">
                                    Введите номер строки для остановки
                                </label>
                                <input type="number" name="stop">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Парсить">
                    </div>
                </form>
            <? endif; ?>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="result-parser">

            </div>
        </div>
    </section>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
</body>
</html>
