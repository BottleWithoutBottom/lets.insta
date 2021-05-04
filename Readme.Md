**Получение даных из Instagram-Basic-Display-Api**

Автор: shredder139@gmail.com

_Существующие поля в настройках модуля:_

Ссылка на сайт (string)

ID пользователя в инстаграм (int)

Токен (string)

Количество отображаемых фото (int)

Токен активен до (timeStamp Y-m-d H:i:s) *Запрещен для редактирования*

Обновлять токен за * дней до истечения (int)

**Откуда взять поля?**

ru: https://active-vision.ru/blog/fotografii-iz-instagram-api/

en(official): https://active-vision.ru/blog/fotografii-iz-instagram-api/

После установки модуля задать его настройки можно тут:

http://joxi.ru/KAg1zqPCKdQOom

_Генерация URL-a_

1) Создайте экземпляр класса LetsInstagram\Lib\Controllers\Connector

        $connector = new Connector();

2) Установите поля, которые необходимо получить для каждой фотографии

        `$connector->setChildrenFields(['id', 'media_url', 'thumbnail_url', 'permalink', 'timestamp']);`
        
3) Установите поля, которые необходимо получить в data (поле "сhildren" должно быть обязательно указано,
если нужно получить фотографии):
UP: ****Для того, чтобы получить поля из children, поля, указанные в children нужно также указать в setFields!!!****

        $connector->setFields(['children']);

4) Сгенерируйте финальный урл, на который будет отправлен запрос к Instagram-Basic-Display-Api:

        $connector->generateUrl();
        
5) Получите данные с API в виде JSON-строки:

        $data = $connector->getResponse();

_Обовление токена_

За обновление токена отвечает класс LetsInstagram\Lib\Workers\Token.

Также важны настройки модуля, а именно поле "Обновлять токен за * дней до истечения", оно отвечает за то, за сколько дней
до истечения токен будет обновляться. На момент написания данного файла в официальной документацией long-live токен живет 60 дней,
следовательно, установив в поле "Обновлять токен за * дней до истечения" значение 5, токен будет обновляться за 5 дней до истечения.

1) Создайте экземпляр класа LetsInstagram\Lib\Workers\Token

        $token = new Token();

2) Метод для проверки "тухлости" токена:

        $token->checkIfTokenExpired();
        
3) Метод для обновления токена:

        $token->refreshToken();
        
**TODO**

1) Обновление токена после смены количества получаемых фото;
2) Настроить автоматическое получение токена в первый раз (без необходимости лезть в официальную документацию)