<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ReceiptServices\PrintReceiptService;

class ReceiptController extends Controller
{
    public function index (PrintReceiptService $printReceiptService)
    {
      $printReceiptService
      ->setModePage()
      // ->setModeDownload()
      ->printPdf();
    }
}
