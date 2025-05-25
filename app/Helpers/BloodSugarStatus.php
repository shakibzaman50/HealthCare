<?php

namespace App\Helpers;

/**
 * Class BSStatusCheck
 * Handles blood sugar status checks and classifications based on different schedules and units
 * @package App\Helpers
 */
class BloodSugarStatus
{
    /**
     * Get blood sugar status based on value, schedule and unit
     * @param float $value Blood sugar value
     * @param string $schedule Schedule type (Fasting, After Eating, 2Hr After Eating)
     * @param string $unit Unit of measurement (mg/dL or mmol/L)
     * @return string Status classification
     */
    public static function check($value, $scheduleId, $unitId)
    {
    
        if ($scheduleId === 1) {
            return self::fasting($value, $unitId);
        } elseif ($scheduleId === 2) {
            return self::afterEating($value, $unitId);
        } elseif ($scheduleId === 3) {
            return self::twoHoursAfterEating($value, $unitId);
        } else {
            return "Doesn't match any schedule";
        }
    }

    /**
     * Get blood sugar status for fasting schedule
     * @param float $value Blood sugar value
     * @param string $unit Unit of measurement (mg/dL or mmol/L)
     * @return string Status classification
     */
    public static function fasting($value, $unitId)
    {
        if ($unitId === 1) {
            if ($value < 80) {
                return "Low Sugar";
            } elseif ($value >= 80 && $value <= 100) {
                return "Normal";
            } elseif ($value >= 101 && $value <= 125) {
                return "Impaired Glucose";
            } elseif ($value >= 126) {
                return "Diabetic";
            } else {
                return "Doesn't match any status";
            }
        }

        if ($unitId === 2) {
            if ($value < 5.6) {
                return "Low Sugar";
            } elseif ($value >= 5.6 && $value <= 7.0) {
                return "Normal";
            } elseif ($value >= 7.0 && $value <= 7.8) {
                return "Impaired Glucose";
            } elseif ($value > 7.8) {
                return "Diabetic";
            } else {
                return "Doesn't match any status";
            }
        }
    }

    /**
     * Get blood sugar status immediately after eating
     * @param float $value Blood sugar value
     * @param string $unit Unit of measurement (mg/dL or mmol/L)
     * @return string Status classification
     */
    public static function afterEating($value, $unitId)
    {
        if ($unitId === 1) {
            if ($value < 170) {
                return "Low Sugar";
            } elseif ($value >= 170 && $value <= 200) {
                return "Normal";
            } elseif ($value >= 190 && $value <= 230) {
                return "Impaired Glucose";
            } elseif ($value > 220) {
                return "Diabetic";
            } else {
                return "Doesn't match any status";
            }
        }

        if ($unitId === 2) {
            if ($value < 7.8) {
                return "Low Sugar";
            } elseif ($value >= 7.8 && $value <= 11.1) {
                return "Normal";
            } elseif ($value > 11.1) {
                return "Diabetic";
            } else {
                return "Doesn't match any status";
            }
        }
    }

    /**
     * Get blood sugar status 2 hours after eating
     * @param float $value Blood sugar value
     * @param string $unit Unit of measurement (mg/dL or mmol/L)
     * @return string Status classification
     */
    public static function twoHoursAfterEating($value, $unit)
    {
        if ($unit === 1) {
            if ($value < 120) {
                return "Low Sugar";
            } elseif ($value >= 120 && $value <= 140) {
                return "Normal";
            } elseif ($value > 140 && $value <= 160) {
                return "Impaired Glucose";
            } elseif ($value > 160) {
                return "Diabetic";
            } else {
                return "Doesn't match any status";
            }
        }

        if ($unit === 2) {
            if ($value < 6.7) {
                return "Low Sugar";
            } elseif ($value >= 6.7 && $value <= 7.8) {
                return "Normal";
            } elseif ($value > 7.8 && $value <= 11.1) {
                return "Impaired Glucose";
            } elseif ($value > 11.1) {
                return "Diabetic";
            } else {
                return "Doesn't match any status";
            }
        }
    }
}