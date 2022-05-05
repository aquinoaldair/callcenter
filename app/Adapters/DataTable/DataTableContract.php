<?php


namespace App\Adapters\DataTable;


use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

interface DataTableContract
{
    public function getData(BaseRepository $repository, Request $request);
}
