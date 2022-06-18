<?php
declare(strict_types=1);

namespace Elephox\Templar;

class EdgeInsets implements Hashable {
	public static function all(null|int|float|Length $length = null): EdgeInsets {
		return new EdgeInsets(
			$length,
			$length,
			$length,
			$length,
		);
	}

	public static function symmetric(
		null|int|float|Length $horizontal = null,
		null|int|float|Length $vertical = null
	): EdgeInsets {
		return new EdgeInsets(
			$horizontal,
			$vertical,
			$horizontal,
			$vertical,
		);
	}

	public static function only(
		null|int|float|Length $left = null,
		null|int|float|Length $top = null,
		null|int|float|Length $right = null,
		null|int|float|Length $bottom = null
	): EdgeInsets {
		return new EdgeInsets(
			$left,
			$top,
			$right,
			$bottom,
		);
	}

	public readonly ?EmittableLength $left;
	public readonly ?EmittableLength $top;
	public readonly ?EmittableLength $right;
	public readonly ?EmittableLength $bottom;

	public function __construct(
		null|int|float|EmittableLength $left,
		null|int|float|EmittableLength $top,
		null|int|float|EmittableLength $right,
		null|int|float|EmittableLength $bottom,
	) {
		$this->left = $left === null
			? null
			: ($left instanceof EmittableLength
				? $left
				: Length::wrap(
					$left
				));
		$this->top =
			$top === null ? null : ($top instanceof EmittableLength ? $top : Length::wrap($top));
		$this->right = $right === null
			? null : ($right instanceof EmittableLength
				? $right : Length::wrap(
					$right
				));
		$this->bottom = $bottom === null
			? null : ($bottom instanceof EmittableLength
				? $bottom : Length::wrap(
					$bottom
				));
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->left,
			$this->top,
			$this->right,
			$this->bottom,
		);
	}

	public function with(
		null|int|float|Length $left = null,
		null|int|float|Length $top = null,
		null|int|float|Length $right = null,
		null|int|float|Length $bottom = null
	): EdgeInsets {
		return new EdgeInsets(
			$left ?? $this->left,
			$top ?? $this->top,
			$right ?? $this->right,
			$bottom ?? $this->bottom,
		);
	}

	public function add(
		null|int|float|Length $left = null,
		null|int|float|Length $top = null,
		null|int|float|Length $right = null,
		null|int|float|Length $bottom = null
	): EdgeInsets {
		return $this->combine(MathOperator::Plus, $left, $top, $right, $bottom);
	}

	public function subtract(
		null|int|float|Length $left = null,
		null|int|float|Length $top = null,
		null|int|float|Length $right = null,
		null|int|float|Length $bottom = null
	): EdgeInsets {
		return $this->combine(MathOperator::Minus, $left, $top, $right, $bottom);
	}

	protected function combine(
		MathOperator $operator,
		null|int|float|Length $left = null,
		null|int|float|Length $top = null,
		null|int|float|Length $right = null,
		null|int|float|Length $bottom = null
	): EdgeInsets {
		$newLeft = new CompoundLength([$this->left, $left], $operator);
		$newTop = new CompoundLength([$this->top, $top], $operator);
		$newRight = new CompoundLength([$this->right, $right], $operator);
		$newBottom = new CompoundLength([$this->bottom, $bottom], $operator);

		return new EdgeInsets(
			$newLeft,
			$newTop,
			$newRight,
			$newBottom,
		);
	}
}