<?php

if (!defined('BASEPATH'))
/*
 * Parameters:
   

  $w
  (float) Cell width. If 0, the cell extends up to the right margin.
   

  $h
  (float) Cell height. Default value: 0.
   

  $txt
  (string) String to print. Default value: empty string.
   

  $border
  (mixed) Indicates if borders must be drawn around the cell. The value can be a number:
  0: no border (default)
  1: frame
  or a string containing some or all of the following characters (in any order):
  L: left
  T: top
  R: right
  B: bottom
  or an array of line styles for each border group - for example: array('LTRB' => array('width' => 2, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0)))
   

  $ln
  (int) Indicates where the current position should go after the call. Possible values are:
  0: to the right (or left for RTL languages)
  1: to the beginning of the next line
  2: below
  Putting 1 is equivalent to putting 0 and calling Ln() just after. Default value: 0.
   

  $align
  (string) Allows to center or align the text. Possible values are:
  L or empty string: left align (default value)
  C: center
  R: right align
  J: justify
   

  $fill
  (boolean) Indicates if the cell background must be painted (true) or transparent (false).
   

  $link
  (mixed) URL or identifier returned by AddLink().
   

  $stretch
  (int) font stretch mode:
  0 = disabled
  1 = horizontal scaling only if text is larger than cell width
  2 = forced horizontal scaling to fit cell width
  3 = character spacing only if text is larger than cell width
  4 = forced character spacing to fit cell width
  General font stretching and scaling values will be preserved when possible.
   

  $ignore_min_height
  (boolean) if true ignore automatic minimum height value.
   

  $calign
  (string) cell vertical alignment relative to the specified Y value. Possible values are:
  T : cell top
  C : center
  B : cell bottom
  A : font top
  L : font baseline
  D : font bottom
   

  $valign
  (string) text vertical alignment inside the cell. Possible values are:
  T : top
  C : center
  B : bottom
 */
    exit('No direct script access allowed');
// extend TCPF with custom functions
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {

    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach ($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    // creditInformation table
    public function creditInformation($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(125, 116, 116);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        // Header
        $w = array(105, 25, 25, 25);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 6, ($row[2]), 'LR', 0, 'R', $fill);
            $this->Cell($w[3], 6, ($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

    public function ssummery($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(125, 116, 116);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        // Header
        $w = array(105, 25, 25);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        $x = 15;
        $y = 2;
        $yy = 0;
        $hh = 0;
        $sum = 0;
        foreach ($data as $k => $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 6, number_format($row[2], 2, '.', ','), 'LR', 0, 'R', $fill);
            // $this->Cell($w[3], 6, ($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
            $yy++;
            $hh +=5.9 ;
            $sum +=$row[2];
        }
        //var_dump($fill);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        //var_dump($yy +$hh);
        $this->SetXY($x, $y + ($yy + $hh));
        //$this->Cell($w, $h, $txt, $border, $ln, $align);
        $this->Cell(70, 5, 'Total Payment', 0, '', 'L');
        $this->SetXY($x + 130, $y + ($yy + $hh));
        $this->Cell(25, 5, number_format($sum, 2, '.', ','), 'B', '', 'R');
        $this->SetXY($x, $y + ($yy + $hh) + 1);
        $this->Cell(155, 5, '', 'B', '', 'R');
    }
    public function csummery($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(125, 116, 116);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        // Header
        $w = array(105, 25, 25);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        $x = 15;
        $y = 2;
        $yy = 0;
        $hh = 0;
        $sum = 0;
        foreach ($data as $k => $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 6, number_format($row[2], 2, '.', ','), 'LR', 0, 'R', $fill);
            // $this->Cell($w[3], 6, ($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
            $yy++;
            $hh +=7.5 ;
            $sum +=$row[2];
        }
        //var_dump($fill);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        //var_dump($yy +$hh);
        $this->SetXY($x, $y + ($yy + $hh));
        //$this->Cell($w, $h, $txt, $border, $ln, $align);
        $this->Cell(70, 5, 'Total Payment', 0, '', 'L');
        $this->SetXY($x + 130, $y + ($yy + $hh));
        $this->Cell(25, 5, number_format($sum, 2, '.', ','), 'B', '', 'R');
        $this->SetXY($x, $y + ($yy + $hh) + 1);
        $this->Cell(155, 5, '', 'B', '', 'R');
    }
    public function cashPayment($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(125, 116, 116);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        // Header
        $w = array(105, 25, 25);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        $x = 15;
        $y = 2;
        $yy = 0;
        $hh = 0;
        $sum = 0;
        foreach ($data as $k => $row) {
            $this->Cell($w[0], 5, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 5, $row[1], 'LR', 0, 'R', $fill);
            $this->Cell($w[2], 5, number_format($row[2], 2, '.', ','), 'LR', 0, 'R', $fill);
            // $this->Cell($w[3], 6, ($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
            $yy++;
            $hh +=5.1 ;
            $sum +=$row[2];
        }
        //var_dump($fill);
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln();
        //var_dump($yy +$hh);
        $this->SetXY($x, $y + ($yy + $hh));
        //$this->Cell($w, $h, $txt, $border, $ln, $align);
        $this->Cell(70, 5, 'Total Payment', 0, '', 'L');
        $this->SetXY($x + 130, $y + ($yy + $hh));
        $this->Cell(25, 5, number_format($sum, 2, '.', ','), 'B', '', 'R');
        $this->SetXY($x, $y + ($yy + $hh) + 1);
        $this->Cell(155, 5, '', 'B', '', 'R');
    }

    public function userInformation($header, $data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(125, 116, 116);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        // Header
        $w = array(20, 25, 60, 75);
        $num_headers = count($header);
        for ($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach ($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
            $this->Cell($w[2], 6, ($row[2]), 'LR', 0, 'L', $fill);
            $this->Cell($w[3], 6, ($row[3]), 'LR', 0, 'R', $fill);
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }

}
