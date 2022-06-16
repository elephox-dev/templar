<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Angle extends Value {
	public static function inDeg(float $value): Angle {
		return new static($value, AngleUnit::Deg);
	}

	public static function inRad(float $value): Angle {
		return new static($value, AngleUnit::Rad);
	}

	public function __construct(
		private readonly float $value,
		private readonly AngleUnit $unit,
		private readonly int $precision = 2,
	) {}

	public function unit(): AngleUnit {
		return $this->unit;
	}

	public function value(): float {
		return $this->value;
	}

	public function precision(): int {
		return $this->precision;
	}
}
