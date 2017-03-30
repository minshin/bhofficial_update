<?php namespace Xeor\Comments\Models;

use Model;

/**
 * Vote Model
 */
class Vote extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'xeor_comments_votes';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'comments' => ['Xeor\Comments\Models\Comment']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

}