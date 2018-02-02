<?php

namespace App\Infrastructure\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DataNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('Data not found',null,404);
    }
}
