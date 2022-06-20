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

	public function __toString(): string {
		return implode(
			' ' . $this->operator->value . ' ',
			array_filter($this->lengths)
		);
	}

	public function toEmittable(): string {
		$lengths = array_filter($this->lengths);
		if (count($lengths) === 1) {
			return (string) $lengths[0];
		}

		return "calc($this)";
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->operator,
			...$this->lengths,
		);
	}
}