<?php
/**
 * Created by PhpStorm.
 * User: lennart
 * Date: 05.09.17
 * Time: 13:59
 */

namespace App;


use Esensi\Model\Contracts\ValidatingModelInterface;
use Esensi\Model\Traits\ValidatingModelTrait;
use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission implements ValidatingModelInterface
{

    use ValidatingModelTrait;

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