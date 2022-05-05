<?php


namespace App\Repositories\Role;

use Illuminate\Http\Request;


interface RoleRepositoryInterface
{
    public function customPaginate($perPage, Request $request);

    public function fillables();
}
