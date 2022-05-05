<?php


namespace App\Adapters\DataTable\VueGoodTable;


use App\Adapters\DataTable\DataTableContract;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;

class VueGoodTable implements DataTableContract
{

    public function getData(BaseRepository $repository, Request $request)
    {
        $result =  $repository->customPaginate($request->perPage, $request);

        return [
            "totalRecords" => $result->total(),
            "rows" =>  $result->items(),
            "request" => $request->all()
        ];
    }
}
