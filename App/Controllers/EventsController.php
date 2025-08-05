<?php

namespace App\Controllers;

use App\Services\DataService;
use App\Responses\Response;
use App\Responses\SuccessResponse;
use App\Responses\ErrorResponse;

class EventsController
{

    public function index(): Response
    {
        $srv = new DataService();
        $id = $_GET['id'] == '' ? null : $_GET['id'];
        if(isset($id) && !is_numeric($id)){
            return new ErrorResponse('ID must be int');
        }
        $event = $srv->getEvents($id);
        if(!isset($event)){
            return new ErrorResponse("Event Not Found", 404);
        }
        return new SuccessResponse(json_encode($event));
    }
}