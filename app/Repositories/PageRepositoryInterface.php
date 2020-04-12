<?php


namespace App\Repositories;

use App\Page;

interface PageRepositoryInterface
{
    public function update($page, array $data, $lang): Page;
}
