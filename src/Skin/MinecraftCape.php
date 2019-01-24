<?php
declare(strict_types=1);

namespace Playzone\Skin;

use Playzone\Skin\Exceptions\SkinBadSizeException;
use Playzone\Skin\Exceptions\SkinException;

class MinecraftCape
{
    private $orig_cape;
    private $cape;
    private $elytra;

    private $sizes         = [22, 64, 128, 256, 512];
    private $width         = 0;
    private $height        = 0;
    private $cape_width    = 0;
    private $cape_height   = 0;
    private $elytra_width  = 0;
    private $elytra_height = 0;


    /**
     * Load cape image from PNG file
     *
     * @param string $filename
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    public function loadPNG(string $filename): void
    {
        $cape = imagecreatefrompng($filename);
        if ($cape === false) {
            throw new SkinException('Bad skin data');
        }
        $this->processSkinImage($cape);
    }

    /**
     * Load cape image from string
     *
     * @param string $strImage
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    public function loadString(string $strImage): void
    {
        $cape = imagecreatefromstring($strImage);
        if ($cape === false) {
            throw new SkinException('Bad skin data');
        }
        $this->processSkinImage($cape);
    }

    /**
     * Load cape data from BASE64 encoded string
     *
     * @param string $base64Image
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    public function loadBase64(string $base64Image): void
    {
        $strImg = base64_decode($base64Image);

        if ($strImg === false) {
            throw new SkinException ('Bad BASE64 string given.');
        }

        $cape = imagecreatefromstring($strImg);
        if ($cape === false) {
            throw new SkinException('Bad skin data');
        }
        $this->processSkinImage($cape);
    }

    /**
     * Get full image
     *
     * @param bool $show_cape
     * @param bool $show_elytra
     * @return resource
     * @throws SkinException
     */
    public function getFullCape(bool $show_cape = false, bool $show_elytra = false)
    {
        if ($show_cape && $show_elytra) {
            return $this->orig_cape;
        }
        $img = $this->createEmptyImg($this->width, $this->height);

        if ($show_cape) {
            imagecopyresampled($img, $this->orig_cape, 0, 0, 0, 0, $this->cape_width, $this->cape_height, $this->cape_width, $this->cape_height);
        }
        if ($show_elytra) {
            imagecopyresampled($img, $this->orig_cape, $this->cape_width, 0, $this->cape_width, 0, $this->elytra_width, $this->elytra_height, $this->elytra_width, $this->elytra_height);
        }
        return $img;
    }

    /**
     * Get cape image
     *
     * @return resource
     */
    public function getCape()
    {
        return $this->cape;
    }

    /**
     * Get elytra image
     *
     * @return resource
     */
    public function getElytra()
    {
        return $this->elytra;
    }

    /**
     * Process cape image
     *
     * @param resource $cape
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    private function processSkinImage($cape): void
    {
        $width  = imagesx($cape);
        $height = imagesy($cape);

        if (!$this->isCloakSizeCorrect($width, $height)) {
            throw new SkinBadSizeException($width, $height);
        }
        $this->width  = $width;
        $this->height = $height;

        imagealphablending($cape, false);
        imagesavealpha($cape, true);

        $this->orig_cape = $cape;

        if ($width === 22) {
            $this->convert22CapeTo64();
        }

        if ($width === $height) {
            $this->convertSquareCape();
        }

        $this->cape_width  = 22 * ($this->width / 64);
        $this->cape_height = 17 * ($this->height / 32);

        $this->elytra_width  = $this->width - $this->cape_width;
        $this->elytra_height = $this->height;

        $this->parseCape();
    }

    /**
     * Check is cape size correct. It must be 1:2 or 1:1 ratio
     *
     * @param int $width
     * @param int $height
     * @return bool
     */
    private function isCloakSizeCorrect(int $width, int $height): bool
    {
        if (!\in_array($width, $this->sizes, true)) {
            return false;
        }

        return true;
    }

    /**
     * Get cape height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Get cape width
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Converts old 22*17 px cape to new 64*32
     *
     * @throws SkinException
     */
    private function convert22CapeTo64(): void
    {
        $img = $this->createEmptyImg(64, 32);
        imagecopyresampled($img, $this->orig_cape, 0, 0, 0, 0, 22, 17, 22, 17);
        $this->orig_cape = $img;
    }


    /**
     * Create empty transparent image
     *
     * @param int $width
     * @param int $height
     * @return resource
     * @throws SkinException
     */
    private function createEmptyImg(int $width, int $height)
    {
        $img = imagecreatetruecolor($width, $height);
        if ($img === false) {
            throw new SkinException ('Can\'t create empty image.');
        }
        imagesavealpha($img, true);
        imagealphablending($img, false);
        $col = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefilledrectangle($img, 0, 0, $width, $height, $col);

        return $img;
    }

    /**
     *
     *
     * @throws SkinException
     */
    private function convertSquareCape(): void
    {
        $img = $this->createEmptyImg($this->width * 2, $this->width);
        imagecopyresampled($img, $this->orig_cape, 0, 0, 0, 0, $this->width * 2, $this->width, $this->width * 2, $this->width);
        $this->width     *= 2;
        $this->orig_cape = $img;

    }

    /**
     * @throws SkinException
     */
    private function parseCape(): void
    {
        $this->cape = $this->createEmptyImg($this->cape_width, $this->cape_height);
        imagecopyresampled($this->cape, $this->orig_cape, 0, 0, 0, 0, $this->cape_width, $this->cape_height, $this->cape_width, $this->cape_height);

        $this->elytra = $this->createEmptyImg($this->elytra_width, $this->elytra_height);
        imagecopyresampled($this->elytra, $this->orig_cape, 0, 0, $this->cape_width, 0, $this->elytra_width, $this->elytra_height, $this->elytra_width, $this->elytra_height);
    }
}