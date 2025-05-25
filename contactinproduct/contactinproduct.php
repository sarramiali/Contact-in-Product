<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class contactinproduct extends Module
{
    public function __construct()
    {
        $this->name = 'contactinproduct';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Ali Sarrami';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Contact In Product');
        $this->description = $this->l('Module to add contacts and link them to products.');

        $this->ps_versions_compliancy = ['min' => '8.0.0', 'max' => _PS_VERSION_];
    }

    public function install()
    {
        if (!parent::install() ||
            !$this->registerHook('DisplayContactOnProduct') ||
            !$this->installTab('AdminContactInProduct', 'Contact In Product') ||
            !$this->createTable()
        ) {
            return false;
        }
        return true;
    }

    private function installTab($class_name, $tab_name, $parent = null)
    {
        $tab = new Tab();
        $tab->class_name = $class_name;
        $tab->module = $this->name;
        $tab->id_parent = $parent ?: (int)Tab::getIdFromClassName('IMPROVE'); // یا 0 یا parent دلخواه
        $tab->name = [];
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = $tab_name;
        }

        return $tab->add();
    }

    private function createTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "contactinproduct` (
            `id_contact` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `title` VARCHAR(255) NOT NULL,
            `mobile` VARCHAR(50) NOT NULL,
            `expiration_date` DATE NOT NULL,
            `priority` INT(10) UNSIGNED NOT NULL,
            `id_product` INT(10) UNSIGNED NOT NULL DEFAULT 0,
            PRIMARY KEY (`id_contact`)
        ) ENGINE=" . _MYSQL_ENGINE_ . " DEFAULT CHARSET=utf8mb4;";

        $db = Db::getInstance();

        if (!$db->execute($sql)) {
            PrestaShopLogger::addLog('Error creating contactinproduct table: ' . $db->getMsgError());
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        $id_tab = (int)Tab::getIdFromClassName('AdminContactInProduct');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            $tab->delete();
        }

        Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'contactinproduct`');

        return parent::uninstall();
    }

    public function hookDisplayContactOnProduct($params)
{
    $id_product = (int)Tools::getValue('id_product');
    if (!$id_product) {
        return;
    }

    $sql = '
        SELECT title, mobile, expiration_date
        FROM ' . _DB_PREFIX_ . 'contactinproduct
        WHERE id_product = ' . $id_product . '
        AND expiration_date >= NOW()
        ORDER BY expiration_date ASC';

    $rows = Db::getInstance()->executeS($sql);

    if (!$rows) {
        return;
    }

    $this->context->smarty->assign([
        'contacts' => $rows,
    ]);

    return $this->display(__FILE__, 'views/templates/hook/product_contact.tpl');
}

    public function getContent()
    {
        // لینک به کنترلر مدیریت
        $link = $this->context->link->getAdminLink('AdminContactInProduct');
        $html = '<h2>'.$this->displayName.'</h2>';
        $html .= '<a href="'.$link.'" class="btn btn-default">'.$this->l('مدیریت ردیف‌ها').'</a>';

        return $html;
    }
}
