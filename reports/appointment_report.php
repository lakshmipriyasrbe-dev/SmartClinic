<?php
require_once('../fpdf/fpdf.php');
require_once('../common_file.php');

class AppointmentReport extends FPDF {
    function Header() {
        global $con;
        // Fetch company details
        $stmt = $con->prepare("SELECT * FROM sc_company LIMIT 1");
        $stmt->execute();
        $company = $stmt->fetch();

        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, strtoupper($company['company_name'] ?? 'SMART CLINIC'), 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 5, $company['company_address'] ?? 'Clinic Address', 0, 1, 'C');
        $this->Cell(0, 5, "Email: " . ($company['company_email'] ?? 'info@smartclinic.com'), 0, 1, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Appointment Schedule Report', 0, 1, 'C');
        $this->Ln(5);

        // Table Header
        $this->SetFont('Arial', 'B', 11);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(50, 10, 'Patient Name', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Doctor', 1, 0, 'C', true);
        $this->Cell(50, 10, 'Date & Time', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Status', 1, 1, 'C', true);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new AppointmentReport('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$stmt = $con->prepare("SELECT * FROM " . $GLOBALS['appointment_table'] . " WHERE deleted = 0 ORDER BY appointment_date DESC");
$stmt->execute();
$appointments = $stmt->fetchAll();

foreach ($appointments as $appt) {
    $pdf->Cell(50, 8, $appt['patient_name'], 1);
    $pdf->Cell(50, 8, $appt['consultan_name'], 1);
    $pdf->Cell(50, 8, date('d-m-Y h:i A', strtotime($appt['appointment_date'])), 1);
    $pdf->Cell(40, 8, $appt['status'] ?? 'Confirmed', 1, 1);
}

$pdf->Output('I', 'Appointment_Report.pdf');
?>
