<?php
declare(strict_types=1);

namespace Playzone\Skin\Exceptions;


class SkinBadSizeException extends SkinException
{
    public function __construct(int $width, int $height)
    {
        parent::__construct('Bad skin size: '.$width.'x'.$height);
    }
}