<?php

require_once _PS_MODULE_DIR_ . 'contactinproduct/models/ContactInProductModel.php';

class AdminContactInProductController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = 'contactinproduct';
        $this->identifier = 'id_contact';
        $this->className = 'ContactInProductModel';
        $this->lang = false;
        $this->bootstrap = true;

        parent::__construct();

        $this->fields_list = [
            'id_contact' => ['title' => $this->l('ID'), 'align' => 'center', 'class' => 'fixed-width-xs'],
            'title' => ['title' => $this->l('عنوان')],
            'mobile' => ['title' => $this->l('شماره موبایل')],
            'expiration_date' => ['title' => $this->l('تاریخ انقضا')],
            'priority' => ['title' => $this->l('اولویت')],
            'id_product' => ['title' => $this->l('آیدی محصول'), 'align' => 'center', 'class' => 'fixed-width-xs'],
        ];

        $this->_orderBy = 'expiration_date';
        $this->_orderWay = 'ASC';
    }

    public function renderList()
    {
        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->toolbar_btn['new'] = [
            'href' => self::$currentIndex . '&addcontactinproduct&token=' . $this->token,
            'desc' => $this->l('ایجاد ردیف جدید'),
        ];

        return parent::renderList();
    }

    public function renderForm()
    {
        $this->fields_form = [
            'legend' => ['title' => $this->l('ایجاد/ویرایش ردیف جدید')],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('عنوان'),
                    'name' => 'title',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('شماره موبایل'),
                    'name' => 'mobile',
                    'required' => true,
                ],
                [
                    'type' => 'date',
                    'label' => $this->l('تاریخ انقضا'),
                    'name' => 'expiration_date',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('اولویت'),
                    'name' => 'priority',
                    'required' => true,
                ],
                [
                    'type' => 'text',
                    'label' => $this->l('آیدی محصول'),
                    'name' => 'id_product',
                    'required' => true,
                ],
            ],
            'submit' => ['title' => $this->l('ذخیره')],
        ];

        return parent::renderForm();
    }
}
