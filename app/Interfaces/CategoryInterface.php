<?php

namespace App\Interfaces;

interface CategoryInterface
{
    public function index($params);
    public function createCategory($params);
    public function showCategory($params);
    public function updateCategory($params);
    public function deleteCategory($params);
}
