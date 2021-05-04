<?

if (class_exists('lets_instagram')) return;

class lets_instagram extends CModule {
    public $MODULE_ID = 'lets.instagram';
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_GROUP_RIGHTS = 'Y';
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $this->setMODULENAME('Модуль для подключения к Instagram-Basic-Display-Api');
        $this->setMODULEDESCRIPTION('');
        $this->setPARTNERNAME('Letsrock');
        $this->setPARTNERURI('//Letsrock');
    }

    public function DoInstall()
    {
        global $APPLICATION;

        if (!IsModuleInstalled($this->getMODULEID())) {
            $this->InstallDB();
            $this->InstallFiles();
            $this->InstallComponents();
        }
        return true;
    }

    public function DoUninstall()
    {
        $this->UninstallDB();
        $this->UninstallFiles();

        return true;
    }

    public function InstallDB()
    {
        RegisterModule($this->getMODULEID());
        return true;
    }

    public function UninstallDB()
    {
        UnRegisterModule($this->getMODULEID());
        return true;
    }

    public function InstallFiles()
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . "/local/modules/lets.instagram/install/admin",
            $_SERVER['DOCUMENT_ROOT'] . "/bitrix/admin", true
        );

        return true;
    }

    public function InstallComponents()
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . "/local/modules/lets.instagram/install/components",
            $_SERVER['DOCUMENT_ROOT'] . "/local/components", true, true
        );

        return true;
    }

    public function UninstallFiles()
    {
        DeleteDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . "/local/modules/lets.instagram/install/admin",
            $_SERVER['DOCUMENT_ROOT'] . "/bitrix/admin", true
        );

        DeleteDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . "/local/modules/lets.instagram/install/components",
            $_SERVER['DOCUMENT_ROOT'] . "/local/components", true
        );
        return true;
    }

    /**
     * @return string
     */
    public function getMODULEID()
    {
        return $this->MODULE_ID;
    }

    /**
     * @param string $MODULE_ID
     */
    public function setMODULEID($MODULE_ID)
    {
        $this->MODULE_ID = $MODULE_ID;
    }

    /**
     * @return mixed
     */
    public function getMODULENAME()
    {
        return $this->MODULE_NAME;
    }

    /**
     * @param mixed $MODULE_NAME
     */
    public function setMODULENAME($MODULE_NAME)
    {
        $this->MODULE_NAME = $MODULE_NAME;
    }

    /**
     * @return mixed
     */
    public function getMODULEDESCRIPTION()
    {
        return $this->MODULE_DESCRIPTION;
    }

    /**
     * @param mixed $MODULE_DESCRIPTION
     */
    public function setMODULEDESCRIPTION($MODULE_DESCRIPTION)
    {
        $this->MODULE_DESCRIPTION = $MODULE_DESCRIPTION;
    }

    /**
     * @return string
     */
    public function getMODULEGROUPRIGHTS()
    {
        return $this->MODULE_GROUP_RIGHTS;
    }

    /**
     * @param string $MODULE_GROUP_RIGHTS
     */
    public function setMODULEGROUPRIGHTS($MODULE_GROUP_RIGHTS)
    {
        $this->MODULE_GROUP_RIGHTS = $MODULE_GROUP_RIGHTS;
    }

    /**
     * @return string
     */
    public function getPARTNERNAME()
    {
        return $this->PARTNER_NAME;
    }

    /**
     * @param string $PARTNER_NAME
     */
    public function setPARTNERNAME($PARTNER_NAME)
    {
        $this->PARTNER_NAME = $PARTNER_NAME;
    }

    /**
     * @return mixed
     */
    public function getPARTNERURI()
    {
        return $this->PARTNER_URI;
    }

    /**
     * @param mixed $PARTNER_URI
     */
    public function setPARTNERURI($PARTNER_URI)
    {
        $this->PARTNER_URI = $PARTNER_URI;
    }

}