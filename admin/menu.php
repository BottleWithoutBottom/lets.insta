<?
if ($USER->IsAdmin()) {
    $aMenu = [
        "parent_menu" => "global_menu_content",
        "sort" => 1000,
        "url" => false,
        "text" => "Модуль для подключения к instagram-api",
        "title" => "Модуль для подключения к instagram-api",
        "items" => []
    ];

    $aMenu["items"][] = [
        "text" => "Настройка",
        "url" => "lets_instagram_settings.php",
        "title" => "Настройка",
    ];

    return $aMenu;
}

return false;
