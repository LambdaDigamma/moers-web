<?php
/**
 * Created by PhpStorm.
 * User: lennart
 * Date: 03.09.17
 * Time: 22:29
 */

namespace App;


use Esensi\Model\Contracts\ValidatingModelInterface;
use Esensi\Model\Traits\ValidatingModelTrait;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{

    protected $throwValidationExceptions = true;

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];

    protected $rules = [
        'name'      => 'required|unique:roles',
        'display_name'      => 'required|unique:roles',
    ];

}