<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    public function barcodeIndex(Request $request)
    {
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $image = $generator->getBarcode('081331723', $generator::TYPE_CODE_128_A);

        return response($image)->header('Content-type','image/png');
    }
}
