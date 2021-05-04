<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php");
use Bitrix\Main\Loader;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Application;
use LetsInstagram\Lib\Entity\Settings;

global $APPLICATION;
CUtil::InitJSCore(['jquery']);
$module_id = 'lets.instagram';
Loader::IncludeModule($module_id);

$settingsObj = new Settings();
$siteUrl = Settings::SITE_URL;
$token = Settings::TOKEN;
$photosCount = Settings::PHOTOS_COUNT;
$instaUserId = Settings::USER_ID;
$expireTime = Settings::EXPIRE_TIME;
$refreshDaysCount = Settings::REFRESH_DAYS_COUNT;

IncludeModuleLangFile(__FILE__);

$APPLICATION->SetTitle('Настройки');
if (!Loader::IncludeModule('iblock')) return;
$request = Application::getInstance()->getContext()->getRequest();

ClearVars();
if (
    (strlen($save) && strlen($apply) > 0)
    && $REQUEST_METHOD == "POST"
    && check_bitrix_sessid()
) {
    $requestSiteUrl = $request->getPost($siteUrl);
    $requestToken = $request->getPost($token);
    $requestPhotosCount = $request->getPost($photosCount);
    $requestInstaUserId = $request->getPost($instaUserId);
    $requestRefreshDaysCount = (int)$request->getPost($refreshDaysCount);

    if ($requestSiteUrl) $settingsObj->setSiteUrl($requestSiteUrl);
    if ($requestToken) $settingsObj->setToken($requestToken);
    if ($requestPhotosCount) $settingsObj->setPhotosCount($requestPhotosCount);
    if ($requestInstaUserId) $settingsObj->setUserId($requestInstaUserId);
    if ($requestRefreshDaysCount) $settingsObj->setRefreshDaysCount($requestRefreshDaysCount);
}

$siteUrlValue  = $settingsObj->getSiteUrl();
$tokenValue = $settingsObj->getToken();
$photosCountValue = $settingsObj->getPhotosCount();
$instaUserIdValue = $settingsObj->getUserId();
$expireTimeValue = $settingsObj->getExpireTime();
$refreshDaysCountValue = (int)$settingsObj->getRefreshDaysCount();

$aTabs = [
    [
        "DIV" => "edit1",
        "TAB" => "Настройки",
        "ICON" => "main_settings",
        "TITLE" => "Настройки модуля Instagram-Basic-Display-Api"
    ]
];

$tabControl = new CAdminTabControl("tabControl", $aTabs); ?>
    <style type="text/css">
        .settings-block {
            margin: 0 0 20px 0;
        }

        .settings-block .settings-block-input-block {
            float: left;
            width: 33.3%;
            margin-bottom: 25px;
        }

        .settings-block .settings-block-input-block label {
            display: block;
            margin: 0 0 10px 0;
        }

        .settings-block .settings-block-input-block input[type="text"], .settings-block .settings-block-input-block select, .settings-block .settings-block-input-block textarea {
            width: 90%;
        }
    </style>

<div class="adm-workarea">
    <form method="post" id="options"
          action="<? echo $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($module_id) ?>&amp;lang=<?= LANGUAGE_ID ?>"
          onsubmit="return saveSettings(this);">
        <?= bitrix_sessid_post(); ?>
        <input type="hidden" name="apply" value="Y">
        <? $tabControl->Begin(); ?>
        <? $tabControl->BeginNextTab(); ?>

        <tr class="heading">
            <td colspan="2">Общие настройки</td>
        </tr>

        <tr>
            <td colspan="2">
                <div class='settings-block'>
                    <div class='settings-block-input-block'>
                        <label>Ссылка на сайт</label>
                        <input type='text' name=<?= $siteUrl; ?> value="<?= $siteUrlValue ?>"/>
                    </div>

                    <div class='settings-block-input-block'>
                        <label>ID пользователя в Instagram</label>
                        <input type='text' name='<?= $instaUserId; ?>' value="<?= $instaUserIdValue ?>"/>
                    </div>

                    <div class='settings-block-input-block'>
                        <label>Токен</label>
                        <input type='text' name='<?= $token; ?>' value="<?= $tokenValue ?>"/>
                    </div>

                    <div class='settings-block-input-block'>
                        <label>Количество отображаемых фото</label>
                        <input type='text' name='<?= $photosCount; ?>' value="<?= $photosCountValue ?>"/>
                    </div>

                    <div class='settings-block-input-block'>
                        <label>Токен активен до</label>
                        <input type='text' name='<?= $expireTime; ?>' value="<?= $expireTimeValue ?>" disabled/>
                    </div>

                    <div class='settings-block-input-block'>
                        <label>Обновлять токен за * дней до истечения</label>
                        <input type='text' name='<?= $refreshDaysCount; ?>' value="<?= $refreshDaysCountValue ?>"/>
                    </div>
                </div>
            </td>
        </tr>

        <tr class="adm-detail-required-field">
            <td colspan="2" width="">
                <div class='adm-detail-content-btns'>
                    <input type="submit" class='adm-btn-save' name="save" value="<?= GetMessage("MAIN_SAVE") ?>"
                           title="Сохранить изменения">
                </div>
            </td>
        </tr>

        <? $tabControl->End(); ?>
    </form>

</div>


    <script type="text/javascript">
        function cloneBlock() {
            let container = $('#all_settings_container');
            let block = container.find('.settings-block').last().clone();

            block.find('input').each(function () {
                $(this).val("");
                $(this).prop("checked", false);
            });
            block.find('textarea').each(function () {
                $(this).val("");
            });
            container.append(block);
        }
    </script>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");