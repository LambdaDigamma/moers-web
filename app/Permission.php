<?php
/**
 * Created by PhpStorm.
 * User: lennart
 * Date: 05.09.17
 * Time: 13:59
 */

namespace App;


use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    protected $throwValidationExceptions = true;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    protected $rules = [
        'name' => 'required|unique:permissions',
    ];

}