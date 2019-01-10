<?php
declare(strict_types=1);

namespace Playzone\Skin;

use Playzone\Skin\Exceptions\SkinBadSizeException;
use Playzone\Skin\Exceptions\SkinException;
use Playzone\Skin\Elements\SkinElement;

class MinecraftSkin
{
    private $skin;

    private $sizes  = [64, 128, 256, 512, 1024];
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
    public function getSkin()
    {
        return $this->skin;
    }

    /**
     * Get right leg's images
     *
     * @return SkinElement
     * @throws SkinException
     */
    public function getRightLeg(): SkinElement
    {
        $block_size = $this->getBlockSize();

        $el = new SkinElement();

        $el->front  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->left   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->right  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->back   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->top    = $this->createEmptyImg(1 * $block_size, 1 * $block_size);
        $el->bottom = $this->createEmptyImg(1 * $block_size, 1 * $block_size);

        // Right
        imagecopyresampled($el->right, $this->skin, 0, 0, 0 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Front
        imagecopyresampled($el->front, $this->skin, 0, 0, 1 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Left
        imagecopyresampled($el->left, $this->skin, 0, 0, 2 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Back
        imagecopyresampled($el->back, $this->skin, 0, 0, 3 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Top
        imagecopyresampled($el->top, $this->skin, 0, 0, 1 * $block_size, 4 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);
        // Bottom
        imagecopyresampled($el->bottom, $this->skin, 0, 0, 2 * $block_size, 4 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);

        return $el;
    }

    /**
     * Get left leg's images
     *
     * @return SkinElement
     * @throws SkinException
     */
    public function getLeftLeg(): SkinElement
    {
        $block_size = $this->getBlockSize();

        $el = new SkinElement();

        $el->front  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->left   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->right  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->back   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->top    = $this->createEmptyImg(1 * $block_size, 1 * $block_size);
        $el->bottom = $this->createEmptyImg(1 * $block_size, 1 * $block_size);

        // Right
        imagecopyresampled($el->right, $this->skin, 0, 0, 4 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Front
        imagecopyresampled($el->front, $this->skin, 0, 0, 5 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Left
        imagecopyresampled($el->left, $this->skin, 0, 0, 6 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Back
        imagecopyresampled($el->back, $this->skin, 0, 0, 7 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Top
        imagecopyresampled($el->top, $this->skin, 0, 0, 5 * $block_size, 12 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);
        // Bottom
        imagecopyresampled($el->bottom, $this->skin, 0, 0, 6 * $block_size, 12 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);

        return $el;
    }

    /**
     * Get left arm's images
     *
     * @return SkinElement
     * @throws SkinException
     */
    public function getLeftArm(): SkinElement
    {
        $block_size = $this->getBlockSize();

        $el = new SkinElement();

        $el->front  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->left   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->right  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->back   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->top    = $this->createEmptyImg(1 * $block_size, 1 * $block_size);
        $el->bottom = $this->createEmptyImg(1 * $block_size, 1 * $block_size);

        // Right
        imagecopyresampled($el->right, $this->skin, 0, 0, 8 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Front
        imagecopyresampled($el->front, $this->skin, 0, 0, 9 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Left
        imagecopyresampled($el->left, $this->skin, 0, 0, 10 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Back
        imagecopyresampled($el->back, $this->skin, 0, 0, 11 * $block_size, 13 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Top
        imagecopyresampled($el->top, $this->skin, 0, 0, 9 * $block_size, 12 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);
        // Bottom
        imagecopyresampled($el->bottom, $this->skin, 0, 0, 10 * $block_size, 12 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);

        return $el;
    }

    /**
     * Get left leg's images
     *
     * @return SkinElement
     * @throws SkinException
     */
    public function getRightArm(): SkinElement
    {
        $block_size = $this->getBlockSize();

        $el = new SkinElement();

        $el->front  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->left   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->right  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->back   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->top    = $this->createEmptyImg(1 * $block_size, 1 * $block_size);
        $el->bottom = $this->createEmptyImg(1 * $block_size, 1 * $block_size);

        // Right
        imagecopyresampled($el->right, $this->skin, 0, 0, 10 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Front
        imagecopyresampled($el->front, $this->skin, 0, 0, 11 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Left
        imagecopyresampled($el->left, $this->skin, 0, 0, 12 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);
        // Back
        imagecopyresampled($el->back, $this->skin, 0, 0, 13 * $block_size, 5 * $block_size, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Top
        imagecopyresampled($el->top, $this->skin, 0, 0, 11 * $block_size, 4 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);
        // Bottom
        imagecopyresampled($el->bottom, $this->skin, 0, 0, 12 * $block_size, 4 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);

        return $el;
    }

    /**
     * Get left leg's images
     *
     * @return SkinElement
     * @throws SkinException
     */
    public function getHead(): SkinElement
    {
        $block_size = $this->getBlockSize();

        $el = new SkinElement();

        $el->front  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->left   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->right  = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->back   = $this->createEmptyImg(1 * $block_size, 3 * $block_size);
        $el->top    = $this->createEmptyImg(1 * $block_size, 1 * $block_size);
        $el->bottom = $this->createEmptyImg(1 * $block_size, 1 * $block_size);

        // Right
        imagecopyresampled($el->right, $this->skin, 0, 0, 1 * $block_size, 0 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size);
        // Front
        imagecopyresampled($el->front, $this->skin, 0, 0, 1 * $block_size, 1 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size);
        // Left
        imagecopyresampled($el->left, $this->skin, 0, 0, 1 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size);
        // Back
        imagecopyresampled($el->back, $this->skin, 0, 0, 1 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size);

        // Top
        imagecopyresampled($el->top, $this->skin, 0, 0, 0 * $block_size, 1 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size);
        // Bottom
        imagecopyresampled($el->bottom, $this->skin, 0, 0, 0 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size, 2 * $block_size);

        return $el;
    }

    /******************************************/

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
     * Get size of skin block
     *
     * @return int
     */
    private function getBlockSize(): int
    {
        return (int)($this->width / 16);
    }

    /**
     * Process image: check
     *
     * @param resource $skin
     * @throws SkinBadSizeException
     * @throws SkinException
     */
    private function processSkinImage($skin): void
    {
        $width  = imagesx($skin);
        $height = imagesy($skin);

        if (!$this->isSkinSizeCorrect($width, $height)) {
            throw new SkinBadSizeException($width, $height);
        }
        $this->width  = $width;
        $this->height = $height;

        imagealphablending($skin, false);
        imagesavealpha($skin, true);

        $this->skin   = $skin;

        $this->convertSkinToSquare();
    }

    /**
     * Check is skin size correct. It must be 1:2 or 1:1 ratio
     *
     * @param int $width
     * @param int $height
     * @return bool
     */
    private function isSkinSizeCorrect(int $width, int $height): bool
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

    /**
     * Convert skin format from 1:2 to 1:1
     *
     * @throws SkinException
     */
    private function convertSkinToSquare(): void
    {


        if ($this->width === $this->height) {
            return;
        }

        $block_size = $this->getBlockSize();

        $leg = $this->getRightLeg();
        $arm = $this->getRightArm();


        $img = $this->createEmptyImg($this->width, $this->width);

        imagecopyresampled($img, $this->skin, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);

        // Copy the right side of the leg
        imagecopyresampled($img, $leg->right, 4 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the front side of the leg
        imagecopyresampled($img, $leg->front, 5 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the left side of the leg
        imagecopyresampled($img, $leg->left, 6 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the back side of the leg
        imagecopyresampled($img, $leg->back, 7 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the top side of the leg
        imagecopyresampled($img, $leg->top, 5 * $block_size, 12 * $block_size, 0, 0, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);

        // Copy the bottom side of the leg
        imagecopyresampled($img, $leg->bottom, 6 * $block_size, 12 * $block_size, 0, 0, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);


        // Copy the right side of the arm
        imagecopyresampled($img, $arm->right, 8 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the front side of the arm
        imagecopyresampled($img, $arm->front, 9 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the left side of the arm
        imagecopyresampled($img, $arm->left, 10 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the back side of the arm
        imagecopyresampled($img, $arm->back, 11 * $block_size, 13 * $block_size, 0, 0, 1 * $block_size, 3 * $block_size, 1 * $block_size, 3 * $block_size);

        // Copy the top side of the arm
        imagecopyresampled($img, $arm->top, 9 * $block_size, 12 * $block_size, 0, 0, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);

        // Copy the bottom side of the arm
        imagecopyresampled($img, $arm->bottom, 10 * $block_size, 12 * $block_size, 0, 0, 1 * $block_size, 1 * $block_size, 1 * $block_size, 1 * $block_size);


        imagesavealpha($img, true);

        $this->skin = $img;
    }
}