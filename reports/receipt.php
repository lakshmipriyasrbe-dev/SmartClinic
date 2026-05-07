<?php
require_once('../fpdf/fpdf.php');
require_once('../common_file.php');

function numberToWords($number) {
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'forty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) return false;
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        trigger_error('numberToWords only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
        return false;
    }

    if ($number < 0) return $negative . numberToWords(abs($number));

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[(int) $hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . numberToWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = numberToWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= numberToWords($remainder);
            }
            break;
    }

    return $string;
}

$id = $_GET['id'] ?? '';
if (empty($id)) die("Invalid Request");

// Fetch specific appointment details
$rows = $bf->getTableRecords($GLOBALS['appointment_table'], 'appointment_id', $id);
$appt = $rows[0] ?? null;

if (!$appt) die("Appointment not found");

class PDF extends FPDF {
    function Header() {
        global $bf;
        // Fetch company details
        $company_res = $bf->getTableRecords('sc_company', '', '', 'id ASC LIMIT 1');
        $company = $company_res[0] ?? null;

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, strtoupper($company['company_name'] ?? 'SMART CLINIC'), 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 5, $company['company_address'] ?? 'Clinic Address', 0, 1, 'C');
        $this->Ln(5);
        $this->Line(10, 30, 200, 30);
        $this->Ln(5);
    }
}

$pdf = new PDF('L', 'mm', 'A5');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'PAYMENT RECEIPT', 0, 1, 'C');
$pdf->Ln(5);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 10, 'Patient Name:', 0, 0);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 10, $appt['patient_name'], 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 10, 'Date:', 0, 0);
$pdf->Cell(0, 10, date('d-m-Y', strtotime($appt['appointment_date'])), 0, 1);

$pdf->Cell(40, 10, 'Doctor Name:', 0, 0);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 10, $appt['consultan_name'], 0, 0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 10, 'Contact:', 0, 0);
$pdf->Cell(0, 10, $appt['consultant_number'] ?? 'N/A', 0, 1);

$pdf->Ln(10);
$pdf->SetFillColor(240, 240, 240);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(140, 10, 'Description', 1, 0, 'L', true);
$pdf->Cell(40, 10, 'Amount', 1, 1, 'R', true);

$pdf->SetFont('Arial', '', 11);
$pdf->Cell(140, 10, 'Consultation Fees', 1, 0, 'L');
$pdf->Cell(40, 10, number_format($appt['consultant_fees'], 2), 1, 1, 'R');

$pdf->Ln(5);
$pdf->SetFont('Arial', 'I', 10);
$words = numberToWords($appt['consultant_fees']);
$pdf->Cell(0, 10, 'Amount in words: ' . ucwords($words) . ' Only', 0, 1);

$pdf->Ln(10);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Authorized Signature', 0, 0, 'R');

$pdf->Output('I', 'Receipt_' . $appt['patient_name'] . '.pdf');
?>
