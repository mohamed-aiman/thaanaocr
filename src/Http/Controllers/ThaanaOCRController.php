<?php

namespace Aimme\ThaanaOCR\Http\Controllers;

use Aimme\ThaanaOCR\ThaanaOCR;
use Aimme\ThaanaOCR\Vision\ResponseHandler;
use App\Http\Requests\OCR\ImageFileUploadRequest;
use Illuminate\Http\Request;

class ThaanaOCRController
{
    public function __construct(ThaanaOCR $ocr)
    {
        $this->ocr = $ocr;
    }

    public function dummy()
    {
        $response = new \Aimme\ThaanaOCR\Vision\ResponseHandler();
        $response->encodeBody(storage_path('dummies/vision_api_response.txt'));
        $string = $response->text();

        return response()->json([
            'text' => $string
        ]);
    }

    public function uploadPhoto(ImageFileUploadRequest $request)
    {
        $request->validated();

        if ($path = $request->file('file')->store('/uploaded/ocr/images')) {
            logger(storage_path('app/' . $path));

            $string = $this->ocr->fromImage(storage_path('app/' . $path))->recognise()->getText();

            return response()->json([
                'text' => $string
            ]);
        }
    }

    public function uploadPdf(PDFFileUploadRequest $request)
    {
        // $request->validated();
        // $pdfFile = storage_path('dummies/samplemultiplepagepdf.pdf');

        if ($path = $request->file('file')->store('/uploaded/ocr/pdfs')) {
            $pdfFile = storage_path('app/' . $path);


            $imageFiles = $this->pdfToImages($pdfFile);

            logger($pdfFile);

            $pages = [];

            foreach ($imageFiles as $key => $image) {
                $pages[] = [
                    'page_number' => $key + 1,
                    'text' => 'pages: '. $this->ocr->fromImage($image)->recognise()->getText()
                ];
            }


            return response()->json([
                'pages' => $pages
            ]);
        }
    }

    protected function pdfToImages($pdfFile)
    {
        $fileName = pathinfo($pdfFile)['filename'];
        $pdfPath = storage_path('app/uploaded/ocr/pdfs/');

        $pdf = new \Spatie\PdfToImage\Pdf($pdfFile);
        $numberOfPages = $pdf->getNumberOfPages();

        $imageFiles = [];
        for ($i = 1; $i <= $numberOfPages; $i++) {
            $imageFile = $pdfPath . 'converted_images/' . $fileName . '_' . $i .'.png';
            $pdf->setPage($i)->setOutputFormat('png')->saveImage($imageFile);
            logger($imageFile);
            $imageFiles[] = $imageFile;
        }

        return $imageFiles;
    }

    // sampleonepagepdf
}