<?php

namespace Modules\Core\Exceptions;

use Exception;
use Modules\Core\Utilities\Response;

class PaginationException extends Exception
{
    public static function invalidPerPageProvided()
    {
        throw new self("Page Size Query Parameter Should Be more then 0", Response::HTTP_BAD_REQUEST);
    }
}
