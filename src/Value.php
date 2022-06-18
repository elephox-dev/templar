<?php
declare(strict_types=1);

namespace Elephox\Templar;

abstract class Value implements Emittable {
	abstract public function unit(): ValueUnit;

	abstract public function value(): float;

	abstract public function precision(): int;

	public function __toString(): string {
		$value = $this->value();
		$unit = $this->unit()->toString();
		$scale = 10.0 ** $this->precision();

		$value = round($value * $scale) / $scale;

		if ($value === 0.0) {
			return "0";
		}

		return "$value$unit";
	}

	public function toEmittable(): string {
		return (string) $this;
	}

	public function getHashCode(): int {
		return hexdec(
			substr(
				md5($this->__toString()),
				0,
				8
			)
		);
	}
}