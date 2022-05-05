<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $saved_message = 'Información guardada correctamente';
    protected $updated_message = 'Información actualizada correctamente';
    protected $error_message = 'Error al guardar la información';
    protected $deleted_message = 'La información se ha eliminado correctamente';
}
