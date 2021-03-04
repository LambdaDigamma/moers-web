<?php


namespace App\Repositories;

use App\Models\Page;

interface PageRepositoryInterface
{
    public function update($page, array $data, $lang): Page;
}
