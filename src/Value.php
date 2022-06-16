<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

abstract class Value implements Stringable, Hashable {
	abstract public function unit(): ValueUnit;

	abstract public function value(): float;

	abstract public function precision(): int;

	public function __toString(): string {
		$value = $this->value();
		$unit = $this->unit()->toString();
		$scale = 10 ** $this->precision();

		$value = round($value * $scale) / $scale;

		return "$value$unit";
	}

	public function getHashCode(): int {
		return hexdec(substr(md5($this->__toString()), 0, 8));
	}
}