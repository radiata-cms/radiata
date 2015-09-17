<?php
/**
 * Configurator файл класса.
 * Component Configurator - custom configurator for modules
 *
 * @author    a1exsnow <ash@bigmir.net>
 * @license   BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version   0.1.0
 */

namespace common\modules\radiata\helpers;

use Yii;

class DateHelper
{
    /**
     * Get date from timestamp
     *
     * @param integer $date
     * @param string $format
     * @return string
     */
    static function getDate($date, $format = 'd.m.Y')
    {
        $dateStr = '';

        if($date > 0) {
            if($date >= mktime(0, 0, 0, date("m"), date("d"), date("Y"))) {
                $dateStr = Yii::t('c/radiata', 'Today');
            } elseif($date >= mktime(0, 0, 0, date("m"), date("d"), date("Y"))) {
                $dateStr = Yii::t('c/radiata', 'Yesterday');
            } else {
                $dateStr = Yii::$app->formatter->asDate($date, $format);
            }
        }

        return $dateStr;
    }

    /**
     * Get ago date from timestamp
     *
     * @param integer $timestamp
     * @return string
     */
    static function getAgoDate($timestamp)
    {
        $date = new \DateTime();
        $date->setTimestamp($timestamp);
        $interval = $date->diff(new \DateTime('now'));

        $ago = ' ' . Yii::t('c/radiata', 'ago');

        $years = $interval->y;
        if($years > 1) {
            return $years . ' ' . Yii::t('c/radiata', 'years') . $ago;
        } elseif($years == 1) {
            return $years . ' ' . Yii::t('c/radiata', 'year') . $ago;
        }

        $months = $interval->m;
        if($months > 1) {
            return $months . ' ' . Yii::t('c/radiata', 'months') . $ago;
        } elseif($months == 1) {
            return $months . ' ' . Yii::t('c/radiata', 'month') . $ago;
        }

        $days = $interval->d;
        if($days > 1) {
            return $days . ' ' . Yii::t('c/radiata', 'days') . $ago;
        } elseif($days == 1) {
            return $days . ' ' . Yii::t('c/radiata', 'day') . $ago;
        }

        $hours = $interval->h;
        if($hours > 1) {
            return $hours . ' ' . Yii::t('c/radiata', 'hours') . $ago;
        } elseif($hours == 1) {
            return $hours . ' ' . Yii::t('c/radiata', 'hour') . $ago;
        }

        $minutes = $interval->i;
        if($minutes > 1) {
            return $minutes . ' ' . Yii::t('c/radiata', 'minutes') . $ago;
        } elseif($minutes == 1) {
            return $minutes . ' ' . Yii::t('c/radiata', 'minute') . $ago;
        }

        $seconds = $interval->s;
        if($seconds > 1) {
            return $seconds . ' ' . Yii::t('c/radiata', 'seconds') . $ago;
        } elseif($seconds == 1) {
            return $seconds . ' ' . Yii::t('c/radiata', 'second') . $ago;
        } else {
            return Yii::t('c/radiata', 'Just now');
        }
    }

}