<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Stringable;

class CompoundLength implements EmittableLength {
	protected array $lengths = [];

	/**
	 * @param iterable<mixed, Stringable|int|float|string|EmittableLength> $lengths
	 */
	public function __construct(
		iterable $lengths,
		protected readonly MathOperator $operator,
	) {
		foreach ($lengths as $length) {
			$this->concat($length);
		}
	}

	public function concat(EmittableLength $length): void {
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

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->operator,
			...$this->lengths,
		);
	}
}