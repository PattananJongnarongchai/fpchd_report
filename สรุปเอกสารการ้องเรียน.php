<?php
// กำหนดค่า error_reporting และการแสดงผลข้อผิดพลาด
error_reporting(E_ALL);
ini_set('display_errors', 1);

// เริ่มต้นการทำงานของ output buffer
ob_start();

// ฟังก์ชันสำหรับแปลงวันที่เป็นรูปแบบไทย
function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

// ฟังก์ชันสำหรับสร้าง PDF
function generatePDF($start_date, $end_date)
{
    // ตั้งค่าโฟลเดอร์ที่เก็บ font
    $fontDir = __DIR__ . '/fonts';

    // กำหนดข้อมูลการเชื่อมต่อฐานข้อมูล
    include 'connection/connection.php';

    // ดึงข้อมูลจากฐานข้อมูลตามช่วงวันที่ที่ระบุ
    $mysql_pdftl = $conn->prepare("SELECT *
    FROM qd_documents qd_doc
    LEFT JOIN doc_types dt ON qd_doc.id_type = dt.id_dt
    LEFT JOIN doc_receiving dr ON qd_doc.id_receiving = dr.id_dr
    WHERE created_at BETWEEN :start_date AND :end_date AND dc_results = 'รับข้อร้องเรียน'
    ORDER BY qd_doc.id_dc ASC");
    $mysql_pdftl->execute(array(':start_date' => $start_date, ':end_date' => $end_date));
    $pdftl = $mysql_pdftl->fetchAll();


    require_once __DIR__ . '/vendor/autoload.php';


    $mpdf = new \Mpdf\Mpdf([
        'fontDir' => [__DIR__ . '/fonts'],
        'fontdata' => [
            'sarabun' => [
                'R' => 'THSarabunNew.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' => 'THSarabunNew Bold.ttf',
            ],
        ],

    ]);
    
    // สร้างหน้า PDF
    foreach ($pdftl as $ptl) {
        $createdby = $ptl['created_by'];
        $createdat = $ptl['created_at'];
        $dc_status = $ptl['dc_status'];
        $dc_results = $ptl['dc_results'];
        $dc_discription = $ptl['dc_discription'];
        $dc_manage = $ptl['dc_manage'];
        $type_qd = $ptl['type_qd'];
        $com_title = $ptl['com_title'];
        $document_code = $ptl['document_code'];
        // ถ้ามีข้อมูลที่จะถูกเพิ่มเข้าไป ให้เพิ่มหน้าใหม่
        $mpdf->AddPage();
        
        $mpdf->WriteHTML('<p style="font-size: 16px;" align="right" ><B>' . $document_code  . "<br>" . DateThai($createdat) . '</B></p>');
        $mpdf->WriteHTML('<hr style="width: 100%; height: 2px; background-color: black;">');
        $mpdf->WriteHTML('<p style="font-size: 16px;" align="right"><br></p>');
        $mpdf->WriteHTML('<p style="text-align: center;"><img src="./image/title_logo.png" width="90px" height="90px"></p>');
        $mpdf->WriteHTML('<div style="text-align: center;"><span style="font-size: 28px; "><B>โรงพยาบาลค่ายพิชัยดาบหัก </B></span></div>');
        $mpdf->WriteHTML('<div style="text-align: center;"><span style="font-size: 28px; "><B>เอกสารการร้องเรียน </B></span></div>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>วันเดือนปีที่รับเรื่อง </B><span style="border-bottom: 1px dotted #000000; font-size: 18px">' . DateThai($createdat) . '</span>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>เรื่องที่ร้องเรียน </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $com_title . '</span>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>ผลพิจารณา </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_results . '</span>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>ประเภท </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $type_qd . '</span>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>สถานะ</B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_status . '</span>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>รายละเอียดข้อร้องเรียน </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_discription . '</span>');
        $mpdf->WriteHTML('<span style="font-size: 18px;"><B>การจัดการ </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_manage . '</span>');
        $mpdf->WriteHTML('<p style="font-size: 16px;" align="right"><br></p>');
        $mpdf->WriteHTML('<p style="font-size: 16px;" align="right"><br></p>');
        
        
        $mpdf->WriteHTML('<div style="text-align: right;"><span style="font-size: 18px;"></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px; float: right; margin-right: 100px;">' . $createdby . '</span></div>');
        
        $mpdf->WriteHTML('<div style="text-align: right;"><span style="font-size: 18px;"><B>ผู้ตรวจสอบ </B></span></div>');

      
       
    }

    
    // ส่งเอกสาร PDF ที่สร้างไว้
    $mpdf->Output();
}

// รับค่าพารามิเตอร์ start_date และ end_date และเรียกใช้ฟังก์ชัน generatePDF
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
generatePDF($start_date, $end_date);

// จบการทำงานของ output buffer และส่งผลลัพธ์ออกไปยัง client
ob_end_flush();
