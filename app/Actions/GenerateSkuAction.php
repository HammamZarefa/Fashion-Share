<?php

namespace App\Actions;

class GenerateSkuAction
{
    public static function execute($branch, $section, $category, $product)
    {
        $formattedBranch = str_pad($branch, 2, '0', STR_PAD_LEFT);
        $formattedSection = str_pad($section, 2, '0', STR_PAD_LEFT);
        $formattedCategory = str_pad($category, 3, '0', STR_PAD_LEFT);
        $formattedProduct = str_pad($product, 4, '0', STR_PAD_LEFT);
        $sku = "{$formattedBranch}{$formattedSection}{$formattedCategory}-{$formattedProduct}";
        return $sku;
    }
}
