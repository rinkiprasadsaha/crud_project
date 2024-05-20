<?php

namespace App\Interfaces;

interface ProductInterface
{
    public function index($params);
    public function createProduct($params);
    public function showProduct($params);
    public function updateProduct($params,$id);
    public function deleteProduct($params);
    public function archiveProduct();
    public function restoreProduct($params);
}
