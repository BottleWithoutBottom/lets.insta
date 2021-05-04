<?

namespace LetsInstagram\Lib\Workers;
use LetsInstagram\Lib\Entity\Settings;
use LetsInstagram\Lib\RequestBuilder;

class Token {
    CONST ACCESS_TOKEN = 'access_token';
    CONST GRANT_TYPE = 'grant_type';
    CONST IG_REFRESH_TOKEN = 'ig_refresh_token';
    CONST EXPIRE = 'expires_in';

    protected $requestBuilder;
    protected $settings;

    public function __construct()
    {
        $this->setRequestBuilder(new RequestBuilder());
        $this->setSettings(new Settings());
    }

    public function refreshToken()
    {
        $settings = $this->getSettings();
        $oldToken = $settings->getToken();
        /** формируем урл для отправки запрос на обновлениие токена
         * смотри: https://developers.facebook.com/docs/instagram-basic-display-api/guides/long-lived-access-tokens
         */
        $requestBuilder = $this->getRequestBuilder();
        $requestBuilder->concat(Settings::INSTAGRAM_API_REFRESH_TOKEN_PATH . '?' . static::GRANT_TYPE . '=' . static::IG_REFRESH_TOKEN);
        $requestBuilder->concat('&' . static::ACCESS_TOKEN . '=' . $oldToken);
        $refreshResult = json_decode($requestBuilder->sendRequest()->getResponse());
        if (!empty($refreshResult->{static::EXPIRE})) {
            $this->setExpirationTime($refreshResult->{static::EXPIRE});
        }
    }

    public function setExpirationTime($unixExpire)
    {
        if (empty($unixExpire)) return false;

        $date = date("d-m-Y H:i:s", time() + $unixExpire);
        $this->getSettings()->setExpireTime($date);
        return true;
    }

    public function checkIfTokenExpired()
    {
        $settings = $this->getSettings();

        $tokenExpired = $settings->getExpireTime();
        if (!empty($tokenExpired)) {
            $tokenExpiredTimeUnix = strtotime($tokenExpired);
            $nowTimeUnix = time();

            $secondsRemaining = $tokenExpiredTimeUnix - $nowTimeUnix;
            $daysRemaining = $this->getDaysRemaining($secondsRemaining);

            $settingsAvailableDays = $settings->getRefreshDaysCount();
        }
        if (
            !empty($tokenExpired)
            && $settingsAvailableDays !== null
            && !empty($settingsAvailableDays)
            && $daysRemaining >= $settingsAvailableDays
        ) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return RequestBuilder
     */
    public function getRequestBuilder()
    {
        return $this->requestBuilder;
    }

    /**
     * @param RequestBuilder $requestBuilder
     */
    public function setRequestBuilder($requestBuilder)
    {
        $this->requestBuilder = $requestBuilder;
    }


    /**
     * @return Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param Settings $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    public function getDaysRemaining($seconds)
    {
        return $seconds / Settings::EXPIRE_TIME_SECONDS;
    }
}
