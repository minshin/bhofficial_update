<?php namespace Bohe\Article\Models;

use Model;

/**
 * Model
 */
class Index extends Model
{
	use \October\Rain\Database\Traits\Validation;

	/*
	 * Validation
	 */
	public $rules = [
	];
	
	public $attachMany = [
			'photo' => ['System\Models\File'],
			'qrcode_pic' => ['System\Models\File'],
	];

	public function getLevelOptions($value, $formData)
	{
		return [
				'1' => '普通的',
				'2' => '高级的',
				
		];
	}
/**
 * 提供field的复选框使用
 * @param unknown $value
 * @param unknown $formData
 * @return string[]
 */
	public function getTypeOptions($value, $formData)
	{
		return [
				'1' => '口腔种植',
				'2' => '牙齿正畸',
				'3' => '美容修复',
				'4' => '儿童口腔',
				'5' => '牙周治疗',
	
		];
	}
	
	/*
	 * Disable timestamps by default.
	 * Remove this line if timestamps are defined in the database table.
	 */
	//public $timestamps = false;
	/*
	 * 主键
	 */
	protected $primaryKey = 'id';
	/*
	 * type  values are encoded as JSON before saving and converted to arrays after fetching.
	 */
	protected $jsonable = ['type'];

	/**
	 * @var string The database table used by the model.
	 */
	public $table = 'bohe_article_doctor';
}