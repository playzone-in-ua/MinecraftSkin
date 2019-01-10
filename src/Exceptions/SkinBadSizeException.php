<?php
declare(strict_types=1);

namespace Playzone\Skin\Exceptions;


class SkinBadSizeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Bad skin size');
    }
}