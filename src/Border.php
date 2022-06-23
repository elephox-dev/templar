<?php
declare(strict_types=1);

namespace Elephox\Templar;

class Border implements Emittable {
	public static function all(BorderSide $side): Border {
		return new Border(
			$side,
			$side,
			$side,
			$side,
		);
	}

	public static function symmetric(
		?BorderSide $horizontal = null,
		?BorderSide $vertical = null
	): Border {
		return new Border(
			$vertical,
			$horizontal,
			$vertical,
			$horizontal,
		);
	}

	public static function only(
		?BorderSide $top = null,
		?BorderSide $right = null,
		?BorderSide $bottom = null,
		?BorderSide $left = null
	): Border {
		return new Border(
			$top,
			$right,
			$bottom,
			$left,
		);
	}

	public static function none(): Border {
		return self::all(BorderSide::none());
	}

	public function __construct(
		protected readonly ?BorderSide $top,
		protected readonly ?BorderSide $right,
		protected readonly ?BorderSide $bottom,
		protected readonly ?BorderSide $left,
	) {}

	public function __toString(): string {
		if ($this->top->equals($this->right) && $this->right->equals($this->bottom) &&
			$this->bottom->equals($this->left)) {
			return "border: $this->top;";
		}

		$border = "";

		if ($this->top !== null) {
			$border .= "border-top: $this->top;";
		}

		if ($this->right !== null) {
			$border .= "border-right: $this->right;";
		}

		if ($this->bottom !== null) {
			$border .= "border-bottom: $this->bottom;";
		}

		if ($this->left !== null) {
			$border .= "border-left: $this->left;";
		}

		return $border;
	}

	public function toEmittable(): string {
		return (string)$this;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->top,
			$this->right,
			$this->bottom,
			$this->left,
		);
	}

	public function with(
		?BorderSide $top = null,
		?BorderSide $right = null,
		?BorderSide $bottom = null,
		?BorderSide $left = null
	): Border {
		return new Border(
			$top ?? $this->top,
			$right ?? $this->right,
			$bottom ?? $this->bottom,
			$left ?? $this->left,
		);
	}
}