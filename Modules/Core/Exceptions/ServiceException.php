<?php

namespace Modules\Core\Exceptions;

use Modules\Core\Utilities\Response;

class ServiceException extends BaseException
{
    public static function relationNotFound(string $relation)
    {
        throw new self("Call to undefined relation {$relation} ", Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    public static function duplicatedShiftInTheSameDay(string $duplicatedDays)
    {
        throw new self("Duplicated shifts provided in the same day [$duplicatedDays]", Response::HTTP_BAD_REQUEST);
    }
}
