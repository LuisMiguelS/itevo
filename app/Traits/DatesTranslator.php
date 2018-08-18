<?php

namespace App\Traits;

use Jenssegers\Date\Date;

trait DatesTranslator
{
    /**
     * @param $created_at
     * @return \Jenssegers\Date\Date
     */
    public function getCreatedAtAttribute($created_at)
    {
        return new Date($created_at);
    }

    /**
     * @param $updated_at
     * @return \Jenssegers\Date\Date
     */
    public function getUpdatedAtAttribute($updated_at)
    {
        return new Date($updated_at);
    }

    /**
     * @param $deleted_at
     * @return \Jenssegers\Date\Date
     */
    public function getDeletedAtAttribute($deleted_at)
    {
        return new Date($deleted_at);
    }

    /**
     * @param $birthdate
     * @return \Jenssegers\Date\Date
     */
    public function getBirthdateAttribute($birthdate)
    {
        return new Date($birthdate);
    }

    /**
     * @param $start_date_at
     * @return \Jenssegers\Date\Date
     */
    public function getStartAtAttribute($start_at)
    {
        return new Date($start_at);
    }

    /**
     * @param $ends_at
     * @return \Jenssegers\Date\Date
     */
    public function getEndsAtAttribute($ends_at)
    {
        return new Date($ends_at);
    }

}