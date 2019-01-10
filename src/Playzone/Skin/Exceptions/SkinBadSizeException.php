<?php
declare(strict_types=1);

namespace Playzone\Skin\Exceptions;


class SkinBadSizeException extends SkinException
{
    public function __construct()
    {
        parent::__construct('Bad skin size');
    }
}