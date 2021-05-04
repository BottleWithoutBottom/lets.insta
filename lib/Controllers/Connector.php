<?

namespace LetsInstagram\Lib\Controllers;
use LetsInstagram\Lib\Entity\Settings;
use LetsInstagram\Lib\RequestBuilder;
use LetsInstagram\Lib\Workers\Token as TokenWorker;

class Connector
{
    protected $settings;
    protected $content;
    protected $requestBuilder;
    protected $fields = [];
    protected $childrenFields = [];

    CONST FIELDS = 'fields';
    CONST ACCESS_TOKEN = 'access_token';
    CONST CHILDREN = 'children';
    CONST CHILDREN_FIELDS = 'fields';
    CONST LIMIT = 'limit';

    public function __construct()
    {
        $this->setSettings(new Settings());
        $this->setRequestBuilder(new RequestBuilder());
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    // Перед тем, как генерировать урл, на который будет брошен запрос за медиаданными, не забудьте сформировать массив $childrenFields, в котором указывается,
    // какие поля из фотографий будут использованы

    // !!! делайте это перед тем, как формировать массив $fields !!!


    // в свойство $fields передать те данные,
    // которые требуется получить
    /** Более подробная информация: https://habr.com/ru/sandbox/141670/ */
    public function generateUrl()
    {
        $settings = $this->getSettings();
        $token = $settings->getToken();
        $tokenWorker = new TokenWorker();
        $tokenIsExpired = $tokenWorker->checkIfTokenExpired();
        if ($tokenIsExpired) {
            $tokenWorker->refreshToken();
        }
        $photosCount = $settings->getPhotosCount();
        $userId = $settings->getUserId();
        $this->setChildrenFieldsString();
        $fieldsString = $this->getFieldsAsString();
        if (!empty($token) && !empty($userId) && !empty($fieldsString)) {
            //Устанавливаем fields
            $this->requestBuilder->concat($settings::INSTAGRAM_API_BASE_URL . '?' . static::FIELDS .'=' . $fieldsString);

            // Устанавливаем количество фотографий, если такой параметр имеется
            if (!empty($photosCount)) $this->requestBuilder->concat('&' . static::LIMIT . '=' . (int)$photosCount);

            $this->requestBuilder->concat('&' . static::ACCESS_TOKEN . '=' . $token);
        }

        return false;
    }

    // Устанавливаем значение поля children в формате children{fields=...}
    public function setChildrenFieldsString()
    {
        $fields = $this->getFields();
        $childrenFieldsString = $this->getChildrenFieldsAsString();
        $existingChildrenKey = $this->getFieldKey(static::CHILDREN);
        if (!empty($childrenFieldsString) && $existingChildrenKey !== null) {
            $childrenString = static::CHILDREN . '{' . static::CHILDREN_FIELDS . '=' . $childrenFieldsString . '}';
            foreach($fields as $key => $field) {
                if ($field == static::CHILDREN) {
                    $this->setFieldByKey($key, $childrenString);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return Settings
     */
    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * @param mixed $settings
     */
    public function setSettings($settings)
    {
        $this->settings = $settings;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function getFieldsAsString()
    {
        return implode(',', $this->getFields());
    }

    /**
     * @param array $fields
     * Список всех доступных полей можно найти тут:
     * https://developers.facebook.com/docs/instagram-basic-display-api/reference/media#fields
     */

    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    public function setFieldByKey($key, $field)
    {
        if ($key === null || empty($field)) return false;

        $this->fields[$key] = $field;
        return true;
    }

    public function getFieldKey($value)
    {
        if (empty($value)) return false;

        return array_search($value, $this->getFields());
    }

    /**
     * @return array
     */
    public function getChildrenFields()
    {
        return $this->childrenFields;
    }

    /**
     * @param array $childrenFields
     */
    public function setChildrenFields($childrenFields = [])
    {
        $this->childrenFields = $childrenFields;
    }

    public function getChildrenFieldsAsString()
    {
        return implode(',', $this->getChildrenFields());
    }

    public function getResponse()
    {
       return $this->getRequestBuilder()->sendRequest()->getResponse();
    }

    public function getRequestBuilder()
    {
        return $this->requestBuilder;
    }

    public function setRequestBuilder($requestBuilder)
    {
        $this->requestBuilder = $requestBuilder;
    }

}