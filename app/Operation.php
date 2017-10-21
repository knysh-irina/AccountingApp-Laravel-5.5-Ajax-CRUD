<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';
}
