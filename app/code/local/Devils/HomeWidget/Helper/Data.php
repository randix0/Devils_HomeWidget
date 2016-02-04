<?php

class Devils_HomeWidget_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAvailableSizes()
    {
        return array(
            '548x362' => 'Size #1 (Width = 548px | Height = 362px)',
            '548x548' => 'Size #2 (Width = 548px | Height = 548px)',
        );
    }

    public function getResizedImage($file, $width, $height)
    {
        return $this->_getResizedImage($file, $width, $height);
    }

    protected function _getResizedImage($file, $width, $height = null)
    {
        if (empty($file)) {
            return false;
        }
        $imagePath = $this->getImageFullPath($file);
        $imageFileResized = $width . '_' . (string) $height . DS . $file;
        $imageFileResizedFullPath = $this->getImageCacheFullPath($imageFileResized);
        if (
            !file_exists($imageFileResizedFullPath) && file_exists($imagePath)
            || file_exists($imagePath) && filemtime($imagePath) > filemtime($imageFileResizedFullPath)
        ) {
            $imageObj = new Varien_Image($imagePath);
            $imageObj->constrainOnly(true);
            $imageObj->keepAspectRatio(true);
            $imageObj->keepFrame(true);
            $imageObj->quality(100);
            $imageObj->resize($width, $height);
            $imageObj->save($imageFileResizedFullPath);
        }

        $imageCacheUrl = $this->getImageCacheUrl($imageFileResized);

        if (file_exists($imageFileResizedFullPath)) {
            return $imageCacheUrl;
        }
        return false;
    }

    public function initDetail($imageId)
    {
        if (!Mage::registry('image') && $imageId) {
            $imageId = (int)$imageId;
            $image = Mage::getModel('devils_images/images')->load($imageId);
            Mage::register('image', $image);
        }
        return Mage::registry('image');
    }

    public function getImageDir()
    {
        return 'devils' . DS . 'devils_homewidget' . DS . 'images' . DS;
    }

    public function getImageCacheDir()
    {
        return 'devils' . DS . 'devils_homewidget' . DS . 'cache' . DS;
    }

    public function getImagePath($file = '')
    {
        return $this->getImageDir() . $file;
    }

    public function getImageCachePath($file = '')
    {
        return $this->getImageCacheDir() . $file;
    }

    public function getImageFullPath($file = '')
    {
        return Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $this->getImageDir() . $file;
    }

    public function getImageCacheFullPath($file)
    {
        if (empty($file)) {
            return false;
        }

        return Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . $this->getImageCacheDir() . $file;
    }

    public function getImageUrl($file)
    {
        if (empty($file)) {
            return false;
        }

        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getImageDir() . $file;
    }

    public function getImageCacheUrl($file)
    {
        if (empty($file)) {
            return false;
        }

        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getImageCacheDir() . $file;
    }
}
