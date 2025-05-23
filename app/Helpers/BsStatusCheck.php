<?php

namespace App\Helpers;

/**
 * Class BSStatusCheck
 * Handles blood sugar status checks and classifications based on different schedules and units
 * @package App\Helpers
 */
class BsStatusCheck
{
    /**
     * Get blood sugar status based on value, schedule and unit
     * @param float $value Blood sugar value
     * @param string $schedule Schedule type (Fasting, After Eating, 2Hr After Eating)
     * @param string $unit Unit of measurement (mg/dL or mmol/L)
     * @return string Status classification
     */
    public static function getBsStatus($value, $schedule, $unit)
    {
        switch ($schedule) {
            case "Fasting":
                return self::getBsStatusFasting($value, $unit);
            case "After Eating":
                return self::getBsStatusAfterEating($value, $unit);
            case "2Hr After Eating":
                return self::getBsStatus2HrAfterEating($value, $unit);
            default:
                return "Doesn't match any schedule";
        }
    }

    /**
     * Get blood sugar status for fasting schedule
     * @param float $value Blood sugar value
     * @param string $unit Unit of measurement (mg/dL or mmol/L)
     * @return string Status classification
     */
    public static function getBsStatusFasting($value, $unit)
    {
        if ($unit == "mg/dL") {
            switch (true) {
                case $value < 80:
                    return "Low Sugar";
                case $value >= 80 && $value <= 100:
                    return "Normal";
                case $value >= 101 && $value <= 125:
                    return "Impaired Glucose";
                case $value >= 126:
                    return "Diabetic";
                default:
                    return "Doesn't match any status";
            }
        } else {
            switch (true) {
                case $value < 5.6:
                    return "Low Sugar";
                case $value >= 5.6 && $value <= 7.0:
                    return "Normal";
                case $value >= 7.0 && $value <= 7.8:
                    return "Impaired Glucose";
                case $value > 7.8:
                    return "Diabetic";
                default:
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
    public static function getBsStatusAfterEating($value, $unit)
    {
        if ($unit == "mg/dL") {
            switch (true) {
                case $value < 170:
                    return "Low Sugar";
                case $value >= 170 && $value <= 200:
                    return "Normal";
                case $value >= 190 && $value <= 230:
                    return "Impaired Glucose";
                case $value > 220:
                    return "Diabetic";
                default:
                    return "Doesn't match any status";
            }
        } else {
            switch (true) {
                case $value < 7.8:
                    return "Low Sugar";
                case $value >= 7.8 && $value <= 11.1:
                    return "Normal";
                case $value > 11.1:
                    return "Diabetic";
                default:
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
    public static function getBsStatus2HrAfterEating($value, $unit)
    {
        if ($unit == "mg/dL") {
            switch (true) {
                case $value < 120:
                    return "Low Sugar";
                case $value >= 120 && $value <= 140:
                    return "Normal";
                case $value >= 140 && $value <= 160:
                    return "Impaired Glucose";
                case $value > 200:
                    return "Diabetic";
                default:
                    return "Doesn't match any status";
            }
        } else {
            switch (true) {
                case $value < 6.7:
                    return "Low Sugar";
                case $value >= 6.7 && $value <= 7.8:
                    return "Normal";
                case $value >= 7.8 && $value <= 8.9:
                    return "Impaired Glucose";
                case $value > 11.1:
                    return "Diabetic";
                default:
                    return "Doesn't match any status";
            }
        }
    }
}