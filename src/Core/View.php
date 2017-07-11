<?php

namespace Core;

class View
{
    public function render(string $viewName, array $data = [])
    {
        extract($data);
        require_once "src/Views/$viewName";

    }
}
