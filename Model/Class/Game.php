<?php

namespace Model\Entity;
abstract class Game {
    protected int $id;
    protected string $name;
    protected array $config;
    protected bool $isActive;
    protected float $minBet = 1;
    protected float $maxBet = 426769736767;
    protected string $slug;

    public function __construct(int $id, string $name, array $config, bool $isActive, string $slug, float $minBet, float $maxBet) {
        $this->id = $id;
        $this->name = $name;
        $this->config = $config;
        $this->isActive = $isActive;
        $this->minBet = $minBet;
        $this->maxBet = $maxBet;
        $this->slug = $slug;
    }

    public function isPlayable(): bool {
        return $this->isActive;
    }
    protected function getConfigParam(string $key, $default = null) {
        return $this->config[$key] ?? $default;
    }
    public function isBetValid(float $amount): bool {
        return ($amount >= $this->minBet && $amount <= $this->maxBet);
    }
    public function getSlug(): string {
        return $this->slug;
    }
    public function getMinBet(): float {
        return $this->minBet;
    }
    public function getMaxBet(): float {
        return $this->maxBet;
    }
    abstract public function run(float $betAmount): float;
}