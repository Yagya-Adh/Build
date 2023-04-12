<?php

namespace app\core;


/**
 * @author Yagya
 * @package app\core
 * 
 */

use app\core\db\DbModel as DbDbModel;

abstract class UserModel extends DbDbModel
{

    abstract public function getDisplayName(): string;
}
