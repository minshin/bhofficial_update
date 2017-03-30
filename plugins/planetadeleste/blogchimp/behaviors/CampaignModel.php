<?php
/**
 * cms.teros.uy
 * Created by alvaro.
 * User: alvaro
 * Date: 04/05/16
 * Time: 10:04 AM
 */

namespace PlanetaDelEste\BlogChimp\Behaviors;

use System\Classes\ModelBehavior;

class CampaignModel extends ModelBehavior
{
    /**
     * CampaignModel constructor.
     *
     * @param \October\Rain\Database\Model $model
     */
    public function __construct($model)
    {
        parent::__construct($model);

        $this->model->hasOne['campaign'] = ['\PlanetaDelEste\BlogChimp\Models\Campaign'];
        $this->model->bindEvent('model.beforeDelete', [$this, 'beforeModelDelete']);
    }

    public function beforeModelDelete()
    {
        if ($this->model->hasRelation('campaign')) {
            $campaign = $this->model->campaign;
            if ($campaign) {
                $campaign->delete();
            };
        }
    }

    /**
     * @return boolean
     */
    public function getIsMailChimpAttribute()
    {
        return ($this->model->campaign);
    }
}