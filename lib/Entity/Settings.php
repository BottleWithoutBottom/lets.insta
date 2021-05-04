<?

namespace LetsInstagram\Lib\Entity;
use Bitrix\Main\Config\Option;

class Settings {
    CONST SITE_URL = 'SITE_URL';
    CONST TOKEN = 'TOKEN';
    CONST USER_ID = 'INSTA_USER_ID';
    CONST PHOTOS_COUNT = 'PHOTOS_COUNT';
    CONST EXPIRE_TIME = 'EXPIRE_TIME';
    CONST REFRESH_DAYS_COUNT = 'REFRESH_DAYS_COUNT';
    CONST MODULE_ID = 'lets.instagram';
    CONST INSTAGRAM_API_BASE_URL = 'https://graph.instagram.com/me/media';
    CONST INSTAGRAM_API_REFRESH_TOKEN_PATH = 'https://graph.instagram.com/refresh_access_token';
    CONST DATA = 'data';

    /** 60 дней до протухания токена Long-live токена в секундах(смотри официальную документацию):
     * https://developers.facebook.com/docs/instagram-basic-display-api/reference/refresh_access_token
     */
    CONST EXPIRE_TIME_SECONDS = 86400;

    /**
     * @return mixed
     */
    public function getSiteUrl()
    {
        return Option::get(static::MODULE_ID, static::SITE_URL);
    }

    /**
     * @param string $siteUrl
     * @return bool
     */
    public function setSiteUrl($siteUrl)
    {
        return Option::set(static::MODULE_ID, static::SITE_URL, $siteUrl);
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return Option::get(static::MODULE_ID, static::TOKEN);
    }

    /**
     * @param mixed $token
     * @return bool
     */
    public function setToken($token)
    {
        return Option::set(static::MODULE_ID, static::TOKEN, $token);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return Option::get(static::MODULE_ID, static::USER_ID);
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        return Option::set(static::MODULE_ID, static::USER_ID, $userId);
    }

    /**
     * @return mixed
     */
    public function getPhotosCount()
    {
        return Option::get(static::MODULE_ID, static::PHOTOS_COUNT);
    }

    /**
     * @param mixed $photosCount
     */
    public function setPhotosCount($photosCount)
    {
        return Option::set(static::MODULE_ID, static::PHOTOS_COUNT, $photosCount);
    }

    public function getExpireTime()
    {
        return Option::get(static::MODULE_ID, static::EXPIRE_TIME);
    }

    public function setExpireTime($date)
    {
        return Option::set(static::MODULE_ID, static::EXPIRE_TIME, $date);
    }

    public function getRefreshDaysCount()
    {
        return Option::get(static::MODULE_ID, static::REFRESH_DAYS_COUNT);
    }

    public function setRefreshDaysCount($count)
    {
        return Option::set(static::MODULE_ID, static::REFRESH_DAYS_COUNT, $count);
    }
}