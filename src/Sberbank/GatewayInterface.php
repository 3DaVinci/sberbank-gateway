<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank;

interface GatewayInterface
{
    public function getDefaultParameters() : array;
}