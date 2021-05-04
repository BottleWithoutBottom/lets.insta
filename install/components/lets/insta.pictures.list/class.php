<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \CBitrixComponent;
use LetsInstagram\Lib\Controllers\Connector;
CModule::IncludeModule('lets.instagram');

class PicturesListComponent extends CBitrixComponent {
    protected $connector;

    public function onPrepareComponentsParams($arParams)
    {
        return $arParams;
    }

    public function executeComponent()
    {
        if ($this->startResultCache()) {
            $connector = new Connector();
            $connector->setChildrenFields(['id', 'media_url', 'thumbnail_url', 'permalink']);
            $connector->setFields(['id', 'media_url', 'thumbnail_url', 'permalink', 'children']);
            $connector->generateUrl();
            $data = $connector->getResponse();
            $dataDecoded = json_decode($data);
            $pictures = $dataDecoded->data;
            if (!empty($pictures)) {
                $this->arResult['PICTURES'] = $pictures;
            }

            $this->includeComponentTemplate();
        }

    }
}