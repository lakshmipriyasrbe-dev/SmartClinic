<?php
require_once('../fpdf/fpdf.php');
require_once('../common_file.php');

class DashboardReport extends FPDF {
    function Header() {
        global $con, $bf;
        // Fetch company details
        $company_res = $bf->getTableRecords('sc_company', '', '', 'id ASC LIMIT 1');
        $company = $company_res[0] ?? null;

        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, strtoupper($company['company_name'] ?? 'SMART CLINIC'), 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $company['company_address'] ?? 'Clinic Address', 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Upcoming Appointments Report', 0, 1, 'C');
        $this->Ln(5);

        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(60, 10, 'Patient Name', 1, 0, 'C', true);
        $this->Cell(60, 10, 'Doctor', 1, 0, 'C', true);
        $this->Cell(70, 10, 'Date & Time', 1, 1, 'C', true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new DashboardReport('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$now = date('Y-m-d H:i:s');
$appointments = $bf->getQueryRecords("SELECT * FROM " . $GLOBALS['appointment_table'] . " WHERE deleted = 0 AND appointment_date >= ? ORDER BY appointment_date ASC", [$now]);

foreach ($appointments as $appt) {
    $pdf->Cell(60, 8, $appt['patient_name'], 1);
    $pdf->Cell(60, 8, $appt['consultan_name'], 1);
    $pdf->Cell(70, 8, date('d-m-Y h:i A', strtotime($appt['appointment_date'])), 1, 1);
}

$pdf->Output('I', 'Upcoming_Appointments.pdf');
?>
