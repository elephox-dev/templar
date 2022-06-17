<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Length extends Value implements EmittableLength {
	public static function wrap(
		null|int|float|Length $length,
		LengthUnit $unit = LengthUnit::Px
	): Length {
		if ($length === null) {
			return new Length(0, $unit);
		}

		if ($length instanceof self) {
			return $length;
		}

		return new Length($length, $unit);
	}

	public static function zero(LengthUnit $unit = LengthUnit::Px): Length {
		return new Length(
			0,
			$unit,
		);
	}

	public static function inPx(float $value): Length {
		return new Length(
			$value,
			LengthUnit::Px,
		);
	}

	public static function inRem(float $value): Length {
		return new Length(
			$value,
			LengthUnit::Rem,
		);
	}

	public static function inPercent(float $value): Length {
		return new Length(
			$value,
			LengthUnit::Percent,
		);
	}

	public function __construct(
		private readonly float $value,
		private readonly LengthUnit $unit,
		private readonly int $precision = 2,
	) {}

	public function unit(): LengthUnit {
		return $this->unit;
	}

	public function value(): float {
		return $this->value;
	}

	public function precision(): int {
		return $this->precision;
	}

	public function add(Length $other): Length {
		assert($this->unit === $other->unit, 'Cannot add lengths with different units');

		return new Length(
			$this->value + $other->value,
			$this->unit,
			$this->precision,
		);
	}

	public function asX(): Offset {
		return new Offset(x: $this);
	}

	public function asY(): Offset {
		return new Offset(y: $this);
	}

	public function toEmittable(): string {
		return (string)$this;
	}
}
