<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once("./phpexcel/Classes/PHPExcel/IOFactory.php");
class Export_model extends Base_Model {
    function __construct(){
        parent::__construct ();
        date_default_timezone_set("Asia/Taipei");
        $this->load->model("Transtext_model");
    }

    public function template($title,$index,$data){
        header('Content-Type: text/html; charset=utf-8');
        
        $fileType = 'Excel5';
        $fileName = 'xls_tmp/export.xls';
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $obj = $objReader->load($fileName);
        
        $obj->setActiveSheetIndex(0);
        $sheet = $obj->getActiveSheet();

        foreach ($index as $k => $v) {
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(20);
            $sheet->getColumnDimension('G')->setWidth(15);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(25);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(20);
            $sheet->getColumnDimension('P')->setWidth(20);
            $sheet->getColumnDimension('Q')->setWidth(20);
            $sheet->getColumnDimension('R')->setWidth(20);
            $sheet->getColumnDimension('S')->setWidth(35);
            $sheet->getColumnDimension('T')->setWidth(35);
            $sheet->getColumnDimension('U')->setWidth(35);
            $sheet->getColumnDimension('V')->setWidth(35);
            $sheet->getColumnDimension('W')->setWidth(35);
            $sheet->getColumnDimension('X')->setWidth(35);
            $sheet->getColumnDimension('Y')->setWidth(35);
            $sheet->getColumnDimension('Z')->setWidth(35);
            $sheet->getColumnDimension('AA')->setWidth(35);
            $sheet->getStyle($k.'1')->getAlignment()->setWrapText(true);
            $sheet->setCellValue($k.'1', $v);
        }   

        $y = '2';
        $total_sum = 0;
        foreach ($data as $item) {
            foreach ($item as $k => $v) {
                $sheet->getStyle($k.$y)->getAlignment()->setWrapText(true);
                $sheet->setCellValue($k.$y, $v);
            }
            $y++;
        }

        $new_file_name = $title."_".date("Ymd_His").".xls";
        $filePath = "xls_tmp/".$new_file_name;
        // Write the file
        $objWriter = PHPExcel_IOFactory::createWriter($obj, $fileType);
        // $objWriter->save("php/".rand(1000, 100000).".xls");
        $objWriter->save(iconv("utf-8", "big5", $filePath)); //Window
        // $objWriter->save($new_file_name); //Linux,Mac
// exit;
        //header("Location: ".base_url().$new_file_name);

        return $filePath;
        //配合底下的unlink，即使用了header還是會繼續執行
        ignore_user_abort(true);
        //下載檔案
        $new_file_name = rawurlencode($new_file_name);
        header("Cache-Control: public, must-revalidate");
        header('Content-Disposition: attachment; filename="'.mb_convert_encoding($new_file_name,'UTF-8').'"');
        header("Content-Transfer-Encoding: binary\n");
        readfile(iconv("utf-8", "big5", $filePath));
        //刪除檔案(header下載
        // var_dump($filePath);
        // unlink($filePath);
    }
    public function template_undertaker($title,$index,$data){
        header('Content-Type: text/html; charset=utf-8');
        
        $fileType = 'Excel5';
        $fileName = 'xls_tmp/export.xls';
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $obj = $objReader->load($fileName);
        
        $obj->setActiveSheetIndex(0);
        $sheet = $obj->getActiveSheet();

        foreach ($index as $k => $v) {
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(25);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(25);
            $sheet->getColumnDimension('P')->setWidth(25);
            $sheet->getColumnDimension('Q')->setWidth(25);
            $sheet->getColumnDimension('R')->setWidth(25);
            $sheet->getColumnDimension('S')->setWidth(25);
            $sheet->getColumnDimension('T')->setWidth(25);
            $sheet->getColumnDimension('U')->setWidth(25);
            $sheet->getColumnDimension('V')->setWidth(25);
            $sheet->getColumnDimension('W')->setWidth(25);
            // $sheet->getColumnDimension('X')->setWidth(30);
            // $sheet->getColumnDimension('Y')->setWidth(30);
            // $sheet->getColumnDimension('Z')->setWidth(30);
            // $sheet->getColumnDimension('AA')->setWidth(30);
            $sheet->getStyle($k.'1')->getAlignment()->setWrapText(true);
            $sheet->setCellValue($k.'1', $v);
        }   

        $y = '2';
        $total_sum = 0;
        foreach ($data as $item) {
            foreach ($item as $k => $v) {
                $sheet->getStyle($k.$y)->getAlignment()->setWrapText(true);
                $sheet->setCellValue($k.$y, $v);
            }
            $y++;
        }

        $new_file_name = $title."_".date("Ymd_His").".xls";
        $filePath = "xls_tmp/".$new_file_name;
        // Write the file
        $objWriter = PHPExcel_IOFactory::createWriter($obj, $fileType);
        // $objWriter->save("php/".rand(1000, 100000).".xls");
        $objWriter->save(iconv("utf-8", "big5", $filePath)); //Window
        // $objWriter->save($new_file_name); //Linux,Mac
// exit;
        //header("Location: ".base_url().$new_file_name);

        return $filePath;
        //配合底下的unlink，即使用了header還是會繼續執行
        ignore_user_abort(true);
        //下載檔案
        $new_file_name = rawurlencode($new_file_name);
        header("Cache-Control: public, must-revalidate");
        header('Content-Disposition: attachment; filename="'.mb_convert_encoding($new_file_name,'UTF-8').'"');
        header("Content-Transfer-Encoding: binary\n");
        readfile(iconv("utf-8", "big5", $filePath));
        //刪除檔案(header下載
        // var_dump($filePath);
        // unlink($filePath);
    }
    public function template_all_order($title,$index,$data){
        header('Content-Type: text/html; charset=utf-8');
        
        $fileType = 'Excel5';
        $fileName = 'xls_tmp/export.xls';
        $objReader = PHPExcel_IOFactory::createReader($fileType);
        $obj = $objReader->load($fileName);
        
        $obj->setActiveSheetIndex(0);
        $sheet = $obj->getActiveSheet();

        foreach ($index as $k => $v) {
            $sheet->getColumnDimension('B')->setWidth(15);
            $sheet->getColumnDimension('C')->setWidth(15);
            $sheet->getColumnDimension('D')->setWidth(25);
            $sheet->getColumnDimension('E')->setWidth(15);
            $sheet->getColumnDimension('F')->setWidth(15);
            $sheet->getColumnDimension('G')->setWidth(25);
            $sheet->getColumnDimension('H')->setWidth(15);
            $sheet->getColumnDimension('I')->setWidth(15);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(20);
            $sheet->getColumnDimension('M')->setWidth(20);
            $sheet->getColumnDimension('N')->setWidth(20);
            $sheet->getColumnDimension('O')->setWidth(25);
            $sheet->getColumnDimension('P')->setWidth(25);
            $sheet->getColumnDimension('Q')->setWidth(25);
            $sheet->getColumnDimension('R')->setWidth(25);
            $sheet->getColumnDimension('S')->setWidth(25);
            $sheet->getColumnDimension('T')->setWidth(25);
            $sheet->getColumnDimension('U')->setWidth(25);
            $sheet->getColumnDimension('V')->setWidth(25);
            $sheet->getColumnDimension('W')->setWidth(25);
            // $sheet->getColumnDimension('X')->setWidth(30);
            // $sheet->getColumnDimension('Y')->setWidth(30);
            // $sheet->getColumnDimension('Z')->setWidth(30);
            // $sheet->getColumnDimension('AA')->setWidth(30);
            $sheet->getStyle($k.'1')->getAlignment()->setWrapText(true);
            $sheet->setCellValue($k.'1', $v);
        }   

        $y = '2';
        $total_sum = 0;
        foreach ($data as $item) {
            foreach ($item as $k => $v) {
                $sheet->getStyle($k.$y)->getAlignment()->setWrapText(true);
                $sheet->setCellValue($k.$y, $v);
            }
            $y++;
        }

        $new_file_name = $title."_".date("Ymd_His").".xls";
        $filePath = "xls_tmp/".$new_file_name;
        // Write the file
        $objWriter = PHPExcel_IOFactory::createWriter($obj, $fileType);
        // $objWriter->save("php/".rand(1000, 100000).".xls");
        $objWriter->save(iconv("utf-8", "big5", $filePath)); //Window
        // $objWriter->save($new_file_name); //Linux,Mac

        //header("Location: ".base_url().$new_file_name);

        // return $filePath;
        //配合底下的unlink，即使用了header還是會繼續執行
        ignore_user_abort(true);
        //下載檔案
        $new_file_name = rawurlencode($new_file_name);
        header("Cache-Control: public, must-revalidate");
        header('Content-Disposition: attachment; filename="'.mb_convert_encoding($new_file_name,'UTF-8').'"');
        header("Content-Transfer-Encoding: binary\n");
        readfile(iconv("utf-8", "big5", $filePath));
        //刪除檔案(header下載
        // var_dump($filePath);
        unlink($filePath);
    }
}