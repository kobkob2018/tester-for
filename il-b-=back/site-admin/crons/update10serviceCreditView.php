<?php

require('../../global_func/vars.php');
require("/home/ilan123/domains/10service.co.il/public_html/class.creditMoney.10service.php");

$creditMoney = new creditMoney;

$creditMoney->setCreditBy1000Views();
