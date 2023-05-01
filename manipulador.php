<?php
require('FPDF/fpdf.php');

// Pasta onde estão os arquivos JPG e TIF
$pasta = "arquivos/";

// Pasta onde serão salvos os arquivos PDF
$pasta_destino = "conversion/";

// Cria a pasta de destino caso ela não exista
if (!is_dir($pasta_destino)) {
    mkdir($pasta_destino);
}

// Loop através de todos os arquivos na pasta
foreach (glob($pasta . "*.{jpg,tif}", GLOB_BRACE) as $imagem) {

    // Cria um novo arquivo PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Obtem o tamanho da imagem
    list($largura, $altura) = getimagesize($imagem);

    // Ajusta a largura e altura da imagem para o tamanho da página do PDF
    $pdfLargura = $pdf->GetPageWidth() - 20;
    $pdfAltura = $pdf->GetPageHeight() - 20;
    $escala = min($pdfLargura / $largura, $pdfAltura / $altura);
    $novaLargura = $largura * $escala;
    $novaAltura = $altura * $escala;

    // Adiciona a imagem ao PDF com a nova largura e altura
    $pdf->Image($imagem, 10, 10, $novaLargura, $novaAltura);

    // Salva o PDF com o mesmo nome da imagem, mas com a extensão .pdf, na pasta de destino
    $pdfNome = "conversion/" . basename(substr($imagem, 0, -4)) . ".pdf";
    $pdf->Output("F", $pdfNome);
}
