
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

function DateThai($strDate)
{
    $strYear = date("Y", strtotime($strDate)) + 543;
    $strMonth = date("n", strtotime($strDate));
    $strDay = date("j", strtotime($strDate));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}

function DateThai02($strDate02)
{
    $strYear = date("Y", strtotime($strDate02)) + 543;
    $strMonth = date("n", strtotime($strDate02));
    $strDay = date("j", strtotime($strDate02));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function DateThai03($strDate03)
{
    $strYear = date("Y", strtotime($strDate03)) + 543;
    $strMonth = date("n", strtotime($strDate03));
    $strDay = date("j", strtotime($strDate03));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function DateThai04($strDate04)
{
    $strYear = date("Y", strtotime($strDate04)) + 543;
    $strMonth = date("n", strtotime($strDate04));
    $strDay = date("j", strtotime($strDate04));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
function DateThai05($strDate05)
{
    $strYear = date("Y", strtotime($strDate05)) + 543;
    $strMonth = date("n", strtotime($strDate05));
    $strDay = date("j", strtotime($strDate05));

    $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
    $strMonthThai = $strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
}
date_default_timezone_set('Asia/Bangkok');
$strDate02 = date("Ymd");
date_default_timezone_set('asia/bangkok');
$date = date('Y-m-d');
$id_dc = $_GET['id_dc'];
include 'connection/connection.php';
$mysql_pdftl = $conn->query("SELECT *
FROM qd_documents qd_doc
LEFT  JOIN doc_types dt ON qd_doc.id_type = dt.id_dt
LEFT  JOIN doc_receiving dr ON qd_doc.id_receiving = dr.id_dr

WHERE qd_doc.id_dc  = '$id_dc' ORDER BY qd_doc.id_dc ASC ");
$mysql_pdftl->execute();
$pdftl = $mysql_pdftl->fetchAll();
foreach ($pdftl as $ptl) {
    $createdby = $ptl['created_by'];
    $createdat = $ptl['created_at'];
    $dc_status = $ptl['dc_status'];
    $dc_results = $ptl['dc_results'];
    $dc_discription = $ptl['dc_discription'];
    $dc_manage = $ptl['dc_manage'];

    $type_qd = $ptl['type_qd'];
    $com_title = $ptl['com_title'];

    $document_path = $ptl['document_path'];
    $document_path1 = $ptl['document_path1'];
    $document_code = $ptl['document_code'];
    
    break;
}
date_default_timezone_set('Asia/Bangkok');
require_once __DIR__ . '/vendor/autoload.php';

$zerofill = 4;
echo str_pad($variable, $zerofill, '0', STR_PAD_LEFT); // 0000000123

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

$mpdf->SetHeader('<p style="font-size: 16px;" align="right" >' . $document_code  . "<br>" . DateThai02($strDate02) . '</p>');
$mpdf->WriteHTML('<p style="font-size: 16px;" align="right" ><br><br></p>');
$mpdf->WriteHTML('<p style="text-align: center;"><img src="./image/title_logo.png" width="90px" height="90px"></p>');
$mpdf->WriteHTML('<div style="text-align: center;"><span style="font-size: 28px; "><B>โรงพยาบาลค่ายพิชัยดาบหัก </B></span></div>');
$mpdf->WriteHTML('<div style="text-align: center;"><span style="font-size: 28px; "><B>เอกสารการร้องเรียน </B></span></div>');

$mpdf->WriteHTML('<span style="font-size: 18px;"><B>วันเดือนปีที่รับเรื่อง </B><span style="border-bottom: 1px dotted #000000; font-size: 18px">' . DateThai02($createdat) . '</span>');
$mpdf->WriteHTML('<span style="font-size: 18px;"><B>เรื่องที่ร้องเรียน </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $com_title . '</span>');

$mpdf->WriteHTML('<span style="font-size: 18px;"><B>ผลพิจารณา </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_results . '</span>');
$mpdf->WriteHTML('<span style="font-size: 18px;"><B>ประเภท </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $type_qd . '</span>');

$mpdf->WriteHTML('<span style="font-size: 18px;"><B>สถานะ</B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_status . '</span>');

$mpdf->WriteHTML('<span style="font-size: 18px;"><B>รายละเอียดข้อร้องเรียน </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_discription . '</span>');
$mpdf->WriteHTML('<span style="font-size: 18px;"><B>การจัดการ </B></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px">' . $dc_manage . '</span>');
$mpdf->WriteHTML('<div style="text-align: right;"><span style="font-size: 18px;"></span> <span style="border-bottom: 1px dotted #000000; font-size: 18px; float: right; margin-right: 100px;">' . $createdby . '</span></div>');

$mpdf->WriteHTML('<div style="text-align: right;"><span style="font-size: 18px;"><B>ผู้ตรวจสอบ </B></span></div>');

ob_end_clean();

$mpdf->Output();

?>