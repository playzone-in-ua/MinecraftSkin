# Playzone Minecraft Skins
## Package for working with minecraft skins and capes.

Support minecraft versions:
* 1.8
* 1.9
* 1.10
* 1.11
* 1.12
* 1.13

Support skin sizes:
* 64x32
* 64x64
* 128x64
* 128x128
* 256x128
* 256x256
* 512x256
* 512x512
* 1024x512
* 1024x1024

Support cape sizes:
* 22x17
* 64x32
* 32x32
* 128x64
* 64x64
* 256x128
* 128x128
* 512x256
* 256x256
* 1024x512
* 512x512

## Usage

Simple example:
```
<?php
include 'vendor/autoload.php';

$skin = new \Playzone\Skin\MinecraftCape();

try {
    $skin->loadPNG('cape_22x17.png');
} catch (\Playzone\Skin\Exceptions\SkinException $e) {
    die ('EXCEPTION: '.$e->getMessage());
}

header('Content-Type: image/png');

# Will print standart 64x32 cape image with elytras
imagepng($skin->getFullCape(true, true));
```

Methods:
* MineraftSkin
  * loadPNG (string $filename) - Load skin image from PNG file
  * loadString (string $imgString) - Load skin image from string
  * loadBase64 (string $base64imageString) - Load image from base64 encoded string
  * getWidth () - Return width of the skin  
  * getHeight () - Return height of the skin
  * getSkin () - Return image (resource) with the skin in new format (ex. 64x64)
  * getOldSkin () - Return image (resource) with the skin in old format (ex. 64x32)
  * getRightLeg () - Get right leg from the skin
  * getLeftLeg () - Get left leg from the skin
  * getLeftArm () - Get left arm from the skin
  * getRightArm () - Get right arm from the skin
  * getHead () - Get head from the skin
  * getBody () - Get body from the skin
* MinecraftCape
  * loadPNG (string $filename) - Load cape image from PNG file
  * loadString (string $imgString) - Load cape image from string
  * loadBase64 (string $base64imageString) - Load image from base64 encoded string
  * getWidth () - Return width of the cape  
  * getHeight () - Return height of the cape
  * getFullCape (bool $show_cape = false, bool $show_elytra = false) - Get full image with or without some parts
  * getCape () - Get cape part from image 
  * getElytra () - Get elytra part from image
  
Methods getRightLeg/getLeftLeg/getLeftArm/getRightArm/getHead/getBody returns \Playzone\Skin\Elements\SkinElement:
```
public $front;
public $back;
public $left;
public $right;
public $top;
public $bottom;
```
Each field contains image resource