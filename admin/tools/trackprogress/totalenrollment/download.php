<?php

    if(isset($_POST['type']) && strlen($_POST['type']) > 0)
    {
        /** Include PHPExcel */
        include_once $_SERVER['DOCUMENT_ROOT'].'/lib/PHPExcel/Classes/PHPExcel/IOFactory.php';
        include_once $_SERVER["DOCUMENT_ROOT"].'/admin/tools/trackprogress/TrackProgressController.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        if($_POST['type'] > 0)
        {
            $title = self::SCOREREPORTTITLE;
            $desc = self::SCOREREPORTDESC;
        }
        else
        {
            $title = self::QUICKTRACKTITLE;
            $desc = self::QUICKTRACKDESC;
        }
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("TAP Series")
                                    ->setLastModifiedBy("tapseries.com")
                                    ->setTitle($title)
                                    ->setSubject("TAP Series Report")
                                    ->setDescription($desc);


        // First we add the program infoAdd some data
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Organization')
                    ->setCellValue('A2', 'Instructor')
                    ->setCellValue('A3', 'Dates')
                    ->setCellValue('A4', 'Program')
                    ->setCellValue('B1', $_POST['organization'])
                    ->setCellValue('B2', $_POST['instructor'])
                    ->setCellValue('B3', $_POST['dates'])
                    ->setCellValue('B4', $_POST['program']);

        // Then we need to set the column headers.
        // We will start on row 6 to give a little spacing between program info.
        die(var_dump($_POST['table'][0]));
        for ($i = 0; $i < count($_POST['headers']); $i++) {
            $objPHPExcel ->setActiveSheetIndex(0) ->setCellValue('D6', 'world!');
        
        }

        // Finally dump the data into the rows.
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A6', 'Hello')
                    ->setCellValue('B6', 'world!')
                    ->setCellValue('C6', 'Hello')
                    ->setCellValue('D6', 'world!');


        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

?>