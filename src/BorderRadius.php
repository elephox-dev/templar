<?php
declare(strict_types=1);

namespace Elephox\Templar;

class BorderRadius implements Emittable {
	public static function zero(): self {
		return new self(0, 0, 0, 0);
	}

	public static function all(null|int|float|Length $radius): self {
		return new self($radius, $radius, $radius, $radius);
	}

	protected readonly ?Length $topLeft;
	protected readonly ?Length $topRight;
	protected readonly ?Length $bottomRight;
	protected readonly ?Length $bottomLeft;

	public function __construct(
		null|int|float|Length $topLeft = null,
		null|int|float|Length $topRight = null,
		null|int|float|Length $bottomRight = null,
		null|int|float|Length $bottomLeft = null,
	) {
		$this->topLeft = Length::wrap($topLeft);
		$this->topRight = Length::wrap($topRight);
		$this->bottomRight = Length::wrap($bottomRight);
		$this->bottomLeft = Length::wrap($bottomLeft);
	}

	public function __toString(): string {
		if ($this->topLeft->equals($this->topRight) && $this->topLeft->equals($this->bottomRight) &&
			$this->topLeft->equals($this->bottomLeft)) {
			return $this->topLeft->toEmittable();
		}

		if ($this->topLeft->equals($this->bottomRight) &&
			$this->topRight->equals($this->bottomLeft)) {
			return "{$this->topLeft->toEmittable()} {$this->topRight->toEmittable()}";
		}

		return "{$this->topLeft->toEmittable()} {$this->topRight->toEmittable()} {$this->bottomRight->toEmittable()} {$this->bottomLeft->toEmittable()}";
	}

	public function toEmittable(): string {
		return "border-radius: $this";
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->topLeft,
			$this->topRight,
			$this->bottomRight,
			$this->bottomLeft,
		);
	}
}