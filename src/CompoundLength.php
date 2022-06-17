<?php
declare(strict_types=1);

namespace Elephox\Templar;

class CompoundLength implements EmittableLength {
	protected array $lengths;

	public function __construct(
		array $lengths,
		protected readonly MathOperator $operator,
	) {
		foreach ($lengths as $length) {
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
	}

	public function concat(EmittableLength $length): void {
		$this->lengths[] = $length;
	}

	public function __toString(): string {
		return implode(' ' . $this->operator->value . ' ', array_filter($this->lengths));
	}

	public function toEmittable(): string {
		$lengths = array_filter($this->lengths);
		if (count($lengths) === 1) {
			return (string)$lengths[0];
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