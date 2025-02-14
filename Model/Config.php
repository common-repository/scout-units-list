<?php

namespace ScoutUnitsList\Model;

/**
 * Configuration model
 */
class Config implements ModelInterface
{
    /** @const string */
    const IMAGE_SOURCE_AVATAR = 'a';

    /** @const string */
    const IMAGE_SOURCE_PHOTO = 'p';

    /** @var int */
    protected $cacheTtl = 3600;

    /** @var array */
    protected $orderCategoryIds = [];

    /** @var string|null */
    protected $orderNoFormat;

    /** @var string|null */
    protected $orderNoPlaceholder;

    /** @var string|null */
    protected $shortcodeTemplatesPath;

    /** @var string */
    protected $mapKey = 'AIzaSyAVv2tyh3rLYN0bQlLPyUWkPgGohVUyixE';

    /** @var float */
    protected $mapDefaultLat = .0;

    /** @var float */
    protected $mapDefaultLng = .0;

    /** @var int */
    protected $mapDefaultZoom = 0;

    /** @var string */
    protected $userImageSource = self::IMAGE_SOURCE_AVATAR;

    /** @var string */
    protected $userPhotoSize = '';

    /** @var string|null */
    protected $externalStructureUrl;

    /**
     * Get cache TTL
     *
     * @return int
     */
    public function getCacheTtl()
    {
        return $this->cacheTtl;
    }

    /**
     * Set cache TTL
     *
     * @param int $cacheTtl cache TTL
     *
     * @return self
     */
    public function setCacheTtl($cacheTtl)
    {
        $this->cacheTtl = max(0, (int) $cacheTtl);

        return $this;
    }

    /**
     * Get order category IDs
     *
     * @return array
     */
    public function getOrderCategoryIds()
    {
        return $this->orderCategoryIds;
    }

    /**
     * Are order categories defined
     *
     * @return bool
     */
    public function areOrderCategoriesDefined()
    {
        return count($this->getOrderCategoryIds()) > 0;
    }

    /**
     * Set order category IDs
     *
     * @param mixed $orderCategoryIds order category IDs (mixed types allowed to prevent from plugin version conflicts)
     *
     * @return self
     */
    public function setOrderCategoryIds($orderCategoryIds)
    {
        $this->orderCategoryIds = empty($orderCategoryIds) ? [] : (array) $orderCategoryIds;

        return $this;
    }

    /**
     * Get order number format
     *
     * @return string|null
     */
    public function getOrderNoFormat()
    {
        return $this->orderNoFormat;
    }

    /**
     * Set order number format
     *
     * @param string|null $orderNoFormat order number format
     *
     * @return self
     */
    public function setOrderNoFormat($orderNoFormat)
    {
        $this->orderNoFormat = empty($orderNoFormat) ? null : $orderNoFormat;

        return $this;
    }

    /**
     * Get order number placeholder
     *
     * @return string|null
     */
    public function getOrderNoPlaceholder()
    {
        return $this->orderNoPlaceholder;
    }

    /**
     * Set order number placeholder
     *
     * @param string|null $orderNoPlaceholder order number placeholder
     *
     * @return self
     */
    public function setOrderNoPlaceholder($orderNoPlaceholder)
    {
        $this->orderNoPlaceholder = empty($orderNoPlaceholder) ? null : $orderNoPlaceholder;

        return $this;
    }

    /**
     * Get shortcode templates path
     *
     * @return string|null
     */
    public function getShortcodeTemplatesPath()
    {
        return $this->shortcodeTemplatesPath;
    }

    /**
     * Has shortcode templates path
     *
     * @return bool
     */
    public function hasShortcodeTemplatesPath()
    {
        $hasPath = !empty($this->shortcodeTemplatesPath);

        return $hasPath;
    }

    /**
     * Set shortcode templates path
     *
     * @param string|null $shortcodeTemplatesPath shortcode templates path
     *
     * @return self
     */
    public function setShortcodeTemplatesPath($shortcodeTemplatesPath)
    {
        $this->shortcodeTemplatesPath = empty($shortcodeTemplatesPath) ? null : $shortcodeTemplatesPath;

        return $this;
    }

    /**
     * Get map key
     *
     * @return string
     */
    public function getMapKey()
    {
        return $this->mapKey;
    }

    /**
     * Set map key
     *
     * @param string $mapKey map key
     *
     * @return self
     */
    public function setMapKey($mapKey)
    {
        $this->mapKey = $mapKey;

        return $this;
    }

    /**
     * Get map default latitude
     *
     * @return float
     */
    public function getMapDefaultLat()
    {
        return $this->mapDefaultLat;
    }

    /**
     * Set map default latitude
     *
     * @param float $mapDefaultLat map default latitude
     *
     * @return self
     */
    public function setMapDefaultLat($mapDefaultLat)
    {
        $this->mapDefaultLat = (float) $mapDefaultLat;

        return $this;
    }

    /**
     * Get map default longitude
     *
     * @return float
     */
    public function getMapDefaultLng()
    {
        return $this->mapDefaultLng;
    }

    /**
     * Set map default longitude
     *
     * @param float $mapDefaultLng map default longitude
     *
     * @return self
     */
    public function setMapDefaultLng($mapDefaultLng)
    {
        $this->mapDefaultLng = (float) $mapDefaultLng;

        return $this;
    }

    /**
     * Get map default zoom
     *
     * @return float
     */
    public function getMapDefaultZoom()
    {
        return $this->mapDefaultZoom;
    }

    /**
     * Set map default zoom
     *
     * @param float $mapDefaultZoom map default zoom
     *
     * @return self
     */
    public function setMapDefaultZoom($mapDefaultZoom)
    {
        $this->mapDefaultZoom = max(0, (int) $mapDefaultZoom);

        return $this;
    }

    /**
     * Get user image source
     *
     * @return string
     */
    public function getUserImageSource()
    {
        return $this->userImageSource;
    }

    /**
     * Use avatar images
     *
     * @return bool
     */
    public function useAvatarImages()
    {
        return $this->userImageSource === self::IMAGE_SOURCE_AVATAR;
    }

    /**
     * Use photo images
     *
     * @return bool
     */
    public function usePhotoImages()
    {
        return $this->userImageSource === self::IMAGE_SOURCE_PHOTO;
    }

    /**
     * Set user image source
     *
     * @param string $userImageSource user image source
     *
     * @return self
     */
    public function setUserImageSource($userImageSource)
    {
        $this->userImageSource = $userImageSource;

        return $this;
    }

    /**
     * Get user photo size
     *
     * @return string
     */
    public function getUserPhotoSize()
    {
        $imageSizes = \get_intermediate_image_sizes();
        $userPhotoSize = empty($this->userPhotoSize) || !in_array($this->userPhotoSize, $imageSizes) ?
            User::PHOTO_SIZE_DEFAULT : $this->userPhotoSize;

        return $userPhotoSize;
    }

    /**
     * Set user photo size
     *
     * @param float $userPhotoSize user photo size
     *
     * @return string
     */
    public function setUserPhotoSize($userPhotoSize)
    {
        $this->userPhotoSize = $userPhotoSize;

        return $this;
    }

    /**
     * Get external structure URL
     *
     * @return string|null
     */
    public function getExternalStructureUrl()
    {
        return $this->externalStructureUrl;
    }

    /**
     * Has external structure URL
     *
     * @return bool
     */
    public function hasExternalStructureUrl()
    {
        $hasPath = !empty($this->externalStructureUrl);

        return $hasPath;
    }

    /**
     * Set external structure URL
     *
     * @param string|null $externalStructureUrl external structure URL
     *
     * @return self
     */
    public function setExternalStructureUrl($externalStructureUrl)
    {
        $this->externalStructureUrl = empty($externalStructureUrl) ? null : $externalStructureUrl;

        return $this;
    }

    /**
     * Get structure
     *
     * @return array
     */
    public function getStructure()
    {
        $structure = [];
        foreach (get_object_vars($this) as $key => $value) {
            $structure[$key] = $value;
        }

        return $structure;
    }

    /**
     * Set structure
     *
     * @param array $structure structure
     *
     * @return self
     */
    public function setStructure(array $structure)
    {
        foreach (array_keys(get_object_vars($this)) as $key) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method(array_key_exists($key, $structure) ? $structure[$key] : null);
            }
        }

        return $this;
    }
}
