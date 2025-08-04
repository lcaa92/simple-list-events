<?php

namespace controllers;

use services\DataService;
use responses\Response;
use responses\SuccessResponse;
use responses\ErrorResponse;

class EventsController
{

    public function index(int $id = null): Response
    {
        $srv = new DataService();
        $event = $srv->getEvents($id);
        if(!isset($event)){
            return new ErrorResponse("Event Not Found", 404);
        }
        return new SuccessResponse(json_encode($event));
    }
}