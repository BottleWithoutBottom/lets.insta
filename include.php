<?

\Bitrix\Main\Loader::registerAutoLoadClasses('lets.instagram', [
    'LetsInstagram\Lib\Entity\Settings' => 'lib/Entity/Settings.php',
    'LetsInstagram\Lib\Controllers\Connector' => 'lib/Controllers/Connector.php',
    'LetsInstagram\Lib\Workers\Token' => 'lib/Workers/Token.php',
    'LetsInstagram\Lib\RequestBuilder' => 'lib/RequestBuilder.php',
]);