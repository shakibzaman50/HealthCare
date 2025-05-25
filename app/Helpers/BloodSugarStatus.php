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
     * @param int $scheduleId Schedule ID (1: Fasting, 2: After Eating, 3: 2Hr After Eating)
     * @param int $unitId Unit ID of measurement (1: mg/dL, 2: mmol/L)
     * @return array Status classification with category and range
     */
    public static function check(float $value, int $scheduleId, int $unitId)
    {
        if ($scheduleId === 1) {
            return self::fasting($value, $unitId);
        } elseif ($scheduleId === 2) {
            return self::afterEating($value, $unitId);
        } elseif ($scheduleId === 3) {
            return self::twoHoursAfterEating($value, $unitId);
        } else {
            return [
                'category' => "Doesn't match any schedule",
                'range' => "Unknown"
            ];
        }
    }

    /**
     * Get blood sugar status for fasting schedule
     * @param float $value Blood sugar value
     * @param int $unitId Unit ID of measurement (1: mg/dL, 2: mmol/L)
     * @return array Status classification with category and range
     */
    public static function fasting($value, $unitId)
    {
        if ($unitId === 1) {
            if ($value < 80) {
                return [
                    'category' => "Low Sugar",
                    'range' => "<80",
                ];
            } elseif ($value >= 80 && $value <= 100) {
                return [
                    'category' => "Normal",
                    'range' => "80-100",
                ];
            } elseif ($value >= 101 && $value <= 125) {
                return [
                    'category' => "Impaired Glucose",
                    'range' => "101-125",
                ];
            } elseif ($value >= 126) {
                return [
                    'category' => "Diabetic",
                    'range' => "126+",
                ];
            } else {
                return [
                    'category' => "Doesn't match any status",
                    'range' => "Unknown",
                ];
            }
        }

        if ($unitId === 2) {
            if ($value < 4.4) {
                return [
                    'category' => "Low Sugar",
                    'range' => "<4.4",
                ];
            } elseif ($value >= 4.4 && $value <= 5.5) {
                return [
                    'category' => "Normal",
                    'range' => "4.4-5.5",
                ];
            } elseif ($value >= 5.6 && $value <= 7.0) {
                return [
                    'category' => "Impaired Glucose",
                    'range' => "5.6-7.0",
                ];
            } elseif ($value > 7.0) {
                return [
                    'category' => "Diabetic",
                    'range' => ">7.0",
                ];
            } else {
                return [
                    'category' => "Doesn't match any status",
                    'range' => "Unknown",
                ];
            }
        }
    }

    /**
     * Get blood sugar status immediately after eating
     * @param float $value Blood sugar value
     * @param int $unitId Unit ID of measurement (1: mg/dL, 2: mmol/L)
     * @return array Status classification with category and range
     */
    public static function afterEating($value, $unitId)
    {
        if ($unitId === 1) {
            if ($value < 170) {
                return [
                    'category' => "Low Sugar",
                    'range' => "<170",
                ];
            } elseif ($value >= 170 && $value <= 200) {
                return [
                    'category' => "Normal",
                    'range' => "170-200",
                ];
            } elseif ($value >= 190 && $value <= 230) {
                return [
                    'category' => "Impaired Glucose",
                    'range' => "190-230",
                ];
            } elseif ($value > 220) {
                return [
                    'category' => "Diabetic",
                    'range' => "220-300",
                ];
            } else {
                return [
                    'category' => "Doesn't match any status",
                    'range' => "Unknown",
                ];
            }
        }

        if ($unitId === 2) {
            if ($value < 9.4) {
                return [
                    'category' => "Low Sugar",
                    'range' => "<9.4",
                ];
            } elseif ($value >= 7.8 && $value <= 11.1) {
                return [
                    'category' => "Normal",
                    'range' => "7.8-11.1",
                ];
            } elseif ($value >= 10.5 && $value <= 12.8) {
                return [
                    'category' => "Impaired Glucose",
                    'range' => "10.5-12.8",
                ];
            } elseif ($value > 11.1) {
                return [
                    'category' => "Diabetic",
                    'range' => ">11.1",
                ];
            } else {
                return [
                    'category' => "Doesn't match any status",
                    'range' => "Unknown",
                ];
            }
        }
    }

    /**
     * Get blood sugar status 2 hours after eating
     * @param float $value Blood sugar value
     * @param int $unitId Unit ID of measurement (1: mg/dL, 2: mmol/L)
     * @return array Status classification with category and range
     */
    public static function twoHoursAfterEating($value, $unitId)
    {
        if ($unitId === 1) {
            if ($value < 120) {
                return [
                    'category' => "Low Sugar",
                    'range' => "<120",
                ];
            } elseif ($value >= 120 && $value <= 140) {
                return [
                    'category' => "Normal",
                    'range' => "120-140",
                ];
            } elseif ($value > 140 && $value <= 160) {
                return [
                    'category' => "Impaired Glucose",
                    'range' => "140-160",
                ];
            } elseif ($value > 160) {
                return [
                    'category' => "Diabetic",
                    'range' => ">160",
                ];
            } else {
                return [
                    'category' => "Doesn't match any status",
                    'range' => "Unknown",
                ];
            }
        }

        if ($unitId === 2) {
            if ($value < 6.7) {
                return [
                    'category' => "Low Sugar",
                    'range' => "<6.7",
                ];
            } elseif ($value >= 6.7 && $value <= 7.8) {
                return [
                    'category' => "Normal",
                    'range' => "6.7-7.8",
                ];
            } elseif ($value > 7.8 && $value <= 8.9) {
                return [
                    'category' => "Impaired Glucose",
                    'range' => "7.8-8.9",
                ];
            } elseif ($value > 11.1) {
                return [
                    'category' => "Diabetic",
                    'range' => ">11.1",
                ];
            } else {
                return [
                    'category' => "Doesn't match any status",
                    'range' => "Unknown",
                ];
            }
        }
    }
}