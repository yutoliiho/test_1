<?php
use Encore\Admin\Form;

/* 数据获取 */
use App\Admin\Extensions\GetSupplierData;
Form::extend('SupplierData',GetSupplierData::class);
