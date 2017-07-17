<?php

namespace Core;

use Config\Routing;

class App
{
    public function run()
    {
        //todo implement security
        $security = new Security();
        $security->run();

        //todo Create dependence injections in future!
        $routing = new Routing();
        $router = new Router($routing);
        $router->run();
    }

    //todo front controller


    //todo config


    //todo setting DB


    //todo router
}

