<?php namespace Yang\Tester\Models;

use Model;

/**
 * Model
 */
class Tester extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /*
     * Validation
     */
    public $rules = [
    ];
    
    public $attachMany = [
    		'pic' => ['System\Models\File'],
    		'thepic' => ['System\Models\File'],
    ];
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'yang_tester_';
}