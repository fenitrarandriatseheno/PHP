<?php
include "connexion.php";
require('fpdf/fpdf.php');

$data = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['data']) && !empty($_POST['data'])) {
        $data = $_POST['data'];

        ob_start();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, htmlentities($data), 0, 1);

        $pdf->Output();
        ob_end_flush();
        exit; 
    }
}

$Idreserv=$_GET['Recu_ClientIdreserv'];
$sql3 = "SELECT Nom,Numtel,Design,Type,frais,reserver.place,date_reserv,date_voyage,payement,Montant_avance 
         FROM Client,Voiture,reserver
         WHERE Client.IdClient=reserver.IdClient AND Voiture.Idvoit=reserver.Idvoit
         AND Idreserv='$Idreserv'";
$resultat = mysqli_query($conn, $sql3);

if ($resultat) {
    if ($row = mysqli_fetch_assoc($resultat)) {
        $Nom = $row['Nom'];
        $Numtel = $row['Numtel'];
        $Design = $row['Design'];
        $Type = $row['Type'];
        $frais = $row['frais'];
        $place = $row['place'];
        $date_reserv = $row['date_reserv'];
        $date_voyage = $row['date_voyage'];
        $payement = $row['payement'];
        $Montant = $row['Montant_avance'];
        $Reste= $frais - $Montant; 
        /*if ($Reste!==0) {
            echo "<script>alert(\"le reste doit etre 0ar pour avoir une recu \");</script>";
        }
        else {*/
        
            ob_start();

            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->Image('voiture.png',160,-5.5,40,40);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->SetX(70);
            $pdf->SetY(30);
            $pdf->SetFont(family:'Arial',style:'B',size:16);
            $pdf->Cell(0, 10, 'Gestion des reservations de place de cooperative :', 'TB', 1,'C');
            
            $pdf->SetX(90);
            $pdf->SetY(40);
            $pdf->SetFont(family:'',style:'BIU');
            $pdf->Cell(40, 30, 'Recu Numero ' . $Idreserv . ' :', 0, 1);
            
            $pdf->SetX(30);
            $pdf->SetFont(family:'',style:'BIU');
            $pdf->Cell(40, 10, 'Nom Client :' . $Nom . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetFont(family:'',style:'');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'numero telephone :' . $Numtel . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Date reservation : ' . $date_reserv . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Date voyage :' . $date_voyage . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Voiture :' . $Design . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Type voiture :' . $Type . '', 0, 2);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'place :' . $place . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Frais :' . $frais . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Payement :' . $payement . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'Montant avance :' . $Montant . '', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Cell(40, 10, 'reste :' .$Reste.'', 0, 1);

            $pdf->Ln('18');
            $pdf->SetX(20);
            $pdf->SetFont(family:'',style:'B',size:25);
            $pdf->Cell(40, 10, 'Merci d\'avoir choisi notre cooperative! ', 0, 1);
            
            $pdf->Ln('3');
            $pdf->SetX(20);
            $pdf->Output();

            ob_end_flush();
        }
    } else {
        echo "0 results";
    }
    mysqli_close($conn);
?>

