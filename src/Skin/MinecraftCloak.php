<?php
declare(strict_types=1);

namespace Playzone\Skin;

use Playzone\Skin\Exceptions\SkinBadSizeException;
use Playzone\Skin\Exceptions\SkinException;

class MinecraftCloak
{
    private $cape;

    private $sizes  = [22, 64, 128, 256, 512, 1024];
    private $width  = 0;
    private $height = 0;

    /**
     * Load skin image from PNG file
     *
     * @param string $filename
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    public function loadPNG(string $filename): void
    {
        $skin = imagecreatefrompng($filename);
        if ($skin === false) {
            throw new SkinException('Bad skin data');
        }
        $this->processSkinImage($skin);
    }

    /**
     * Load skin image from string
     *
     * @param string $strImage
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    public function loadString(string $strImage): void
    {
        $skin = imagecreatefromstring($strImage);
        if ($skin === false) {
            throw new SkinException('Bad skin data');
        }
        $this->processSkinImage($skin);
    }

    /**
     * Load skin data from BASE64 encoded string
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

        $skin = imagecreatefromstring($strImg);
        if ($skin === false) {
            throw new SkinException('Bad skin data');
        }
        $this->processSkinImage($skin);
    }

    /**
     * Get skin image
     *
     * @return resource
     */
    public function getCape()
    {
        return $this->cape;
    }

    /**
     * Process image: check
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

        $this->cape = $cape;

        if ($width === 22)
        {
            $this->convertCapeTo64();
        }


    }

    /**
     * Check is skin size correct. It must be 1:2 or 1:1 ratio
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

        if ($height !== $width && $height !== $width / 2) {
            return false;
        }

        return true;
    }

    /**
     * Get skin height
     *
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * Get skin width
     *
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    private function convertCapeTo64() {


    }
}