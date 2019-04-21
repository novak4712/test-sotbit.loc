<?
require_once 'DB.php';
require 'vendor/autoload.php';
require 'MyReadFilter.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;

$db = new DB();
$start = $_POST['start'];
$stop = $_POST['stop'];
$arResultPost = $_POST;
$countResult = count($arResultPost) - 2;
for ($i = 0; $i < $countResult/2; $i++) {
    $arResult[$i]['pole']=$arResultPost['model-name_'.$i];
    $arResult[$i]['column']=$arResultPost['column-name_'.$i];
}


echo "<pre>";
print_r($arResult);
echo "</pre>";

