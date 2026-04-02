<?php
namespace Model\Entity;

interface GameInterface
{
    public function run(float $betAmount, string $choice): float;
    public function isPlayable(): bool;

    public function isBetValid(float $amount): bool;
}