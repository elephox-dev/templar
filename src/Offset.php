<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Offset implements Hashable {
	public static function both(null|int|float|Length $length): Offset {
		return new Offset(
			x: $length,
			y: $length,
		);
	}

	public readonly Length $x;
	public readonly Length $y;

	public function __construct(
		null|int|float|Length $x = null,
		null|int|float|Length $y = null,
	) {
		$this->x = Length::wrap($x);
		$this->y = Length::wrap($y);
	}

	public function __toString(): string {
		return "$this->x $this->y";
	}

	public function with(null|int|float|Length $x = null, null|int|float|Length $y = null): Offset {
		return new Offset(
			$x ?? $this->x,
			$y ?? $this->y
		);
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->x->getHashCode(),
			$this->y->getHashCode(),
		);
	}
}
