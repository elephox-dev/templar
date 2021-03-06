<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

class CompoundLength implements EmittableLength {
	protected array $lengths = [];

	public function __construct(
		iterable $lengths,
		protected readonly MathOperator $operator,
	) {
		foreach ($lengths as $length) {
			if ($length === null) {
				continue;
			}

			assert(
				$length instanceof Stringable || is_string($length) || is_int($length) ||
				is_float($length),
				'Length must be a Stringable, string, int, or float, but got ' .
				get_debug_type($length)
			);

			$this->concat($length);
		}
	}

	public function concat(Stringable|int|float|string $length): void {
		if ($length instanceof self) {
			if ($length->operator === $this->operator) {
				foreach ($length->lengths as $innerLength) {
					$this->lengths[] = $innerLength;
				}
			} else {
				$this->lengths[] = "($length)";
			}
		} else {
			$this->lengths[] = $length;
		}
	}

	public function getParts(): array {

		$parts = [];
		$lastLength = null;
		foreach ($this->lengths as $length) {
			if ($length === null) {
				continue;
			}

			if ($length instanceof Length) {
				if ($lastLength !== null) {
					if ($lastLength->unit() === $length->unit()) {
						$lastLength = $lastLength->add($length);

						continue;
					}

					$parts[] = (string)$lastLength;

					$lastLength = $length;

					continue;
				}

				$lastLength = $length;

				continue;
			}

			$parts[] = (string)$length;
		}

		if ($lastLength !== null) {
			$parts[] = (string)$lastLength;
		}

		return $parts;
	}

	public function __toString(): string {
		return implode(
			' ' . $this->operator->value . ' ',
			$this->getParts(),
		);
	}

	public function toEmittable(): string {
		$parts = $this->getParts();

		if (count($parts) > 1) {
			$str = implode(
				' ' . $this->operator->value . ' ',
				$this->getParts(),
			);

			return "calc($str)";
		}

		return $parts[0];
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->operator,
			...$this->lengths,
		);
	}
}