<?php

namespace App\Services\ReceiptServices;
use \Mpdf\Mpdf;
use \Cache;

class PrintReceiptService
{
  protected $mpdf;
  protected $mode = "page";

  public function __construct()
  {
    $this->mpdf = new \Mpdf\Mpdf();
  }

  protected function countDownload()
  {
    if(Cache::has('downloadCount')) {
        Cache::increment('downloadCount');
    }else {
      Cache::put('downloadCount', 0);
    }
  }

  protected function getCurrentDownloadCount()
  {
    if(!Cache::has('downloadCount')) {
      Cache::put('downloadCount', 0);
    }
    return Cache::get('downloadCount');
  }

  protected function setHtml($html = '<h1>Hello world!!</h1>')
  {
    $this->mpdf->WriteHTML($html);
  }

  protected function fileName()
  {
    $currentDownloadCount = (String)$this->getCurrentDownloadCount();
    return $currentDownloadCount."_testPdf";
  }

  public function setModeDownload()
  {
    $this->mode = "download";
    return $this;
  }

  public function setModePage()
  {
    $this->mode = "page";
    return $this;
  }

  public function printPdf()
  {
    $this->setHtml();

    if($this->mode === "download") {
      $this->mpdf->Output($this->fileName(), 'D');
      $this->countDownload();
    }elseif($this->mode === "page") {
      $this->mpdf->Output();
    }else {
      report("not defined mode");
    }
  }
}
