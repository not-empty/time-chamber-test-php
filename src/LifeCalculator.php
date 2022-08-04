<?php

namespace Tests1Doc;

/**
 * Simple test
 */
class LifeCalculator
{
    public function applyPhisicalDamage(
        int $damage,
        int $defense
    ): int
    {
        if (
            $damage <= 0
        ) {
            return 0;
        }

        $phisicalDamage = $damage - $defense;
        return $phisicalDamage;
    }

    public function applyElementalDamage(
        int $damage,
        int $elementalResistance,
        string $elementDamage,
        string $characterType
    ): int
    {
        $elementsVulnerability = [
            'fire' => 'water',
            'water' => 'wind',
            'earth' => 'fire',
            'wind' => 'earth',
        ];

        if (
            array_search($elementDamage, $elementsVulnerability) === false ||
            array_search($characterType, $elementsVulnerability) === false
        ) {
            return 0;
        }

        $characterVulnerability = $elementsVulnerability[$characterType];

        if ($elementDamage === $characterVulnerability) {
            $elementalDamage = ($damage - $elementalResistance) * 2;
            return $elementalDamage;
        }

        return $elementalDamage = $damage - $elementalResistance;
    }

    public function applyHealPotion(
        int $maxHitPoints,
        int $hitPoints,
        int $potionType,
        int $healEfectivity
    ): int
    {
        if (
            $hitPoints === 0 ||
            $maxHitPoints < $hitPoints
        ) {
            return 0;
        }

        $potions = [
            'red' => 45,
            'yellow' => 175,
            'white' => 325,
        ];

        if (
            array_search($potionType, $potions) === false
        ) {
            return 0;
        }

        $potionHeal = $potions[$potionType];

        $heal = $potionHeal * ($healEfectivity / 100);

        return $heal;
    }
}