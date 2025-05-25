<?php

class ContactInProductModel extends ObjectModel
{
    public $id_contact;
    public $title;
    public $mobile;
    public $expiration_date;
    public $priority;
    public $id_product;

    public static $definition = [
        'table' => 'contactinproduct',
        'primary' => 'id_contact',
        'fields' => [
            'title' => ['type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true, 'size' => 255],
            'mobile' => ['type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'required' => true, 'size' => 50],
            'expiration_date' => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true],
            'priority' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
            'id_product' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true],
        ],
    ];
}
