<?php
declare(strict_types=1);

namespace Playzone\Skin\Exceptions;


class SkinException extends \Exception
{
    public function __construct($msg)
    {
        parent::__construct($msg);
    }
}