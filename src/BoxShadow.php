<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\Colors;

class BoxShadow implements Emittable {
	public static function ambient(): BoxShadow {
		return new BoxShadow(
			blurRadius: 10,
			spreadRadius: -5,
			color: Colors::Shadow(),
		);
	}

	public static function fromElevation(int $elevation, ?Color $color = null): BoxShadow {
		$sigmoid = static fn (float $x) => 1.0 / (1.0 + exp(-$x));

		return new BoxShadow(
			offset: new Offset(y: $sigmoid($elevation) * 10.0),
			blurRadius: $sigmoid($elevation) * 10.0,
			spreadRadius: $sigmoid($elevation) * -5.0,
			color: $color ?? Colors::Shadow(),
		);
	}

	protected readonly Offset $offset;
	protected readonly ?Length $blurRadius;
	protected readonly ?Length $spreadRadius;

	public function __construct(
		?Offset $offset = null,
		null|int|float|Length $blurRadius = null,
		null|int|float|Length $spreadRadius = null,
		protected readonly ?Color $color = null,
		protected readonly bool $inset = false,
	) {
		$this->offset = $offset ?? new Offset();
		$this->blurRadius = $blurRadius !== null ? Length::wrap($blurRadius) : null;
		$this->spreadRadius = $spreadRadius !== null ? Length::wrap($spreadRadius) : null;

		assert(
			$this->blurRadius === null || $this->blurRadius->value() >= 0,
			"Blur radius must be non-negative, got $this->blurRadius",
		);
		assert(
			$this->spreadRadius === null || $this->blurRadius !== null,
			"Spread radius requires blur radius to be set, got $this->spreadRadius",
		);

		// TODO: check length units are possible for each property (e.g. % for blur radius?)
	}

	public function __toString(): string {
		$shadow = (string) $this->offset;

		if ($this->blurRadius !== null) {
			$shadow .= " $this->blurRadius";
		}

		if ($this->spreadRadius !== null) {
			$shadow .= " $this->spreadRadius";
		}

		if ($this->color !== null) {
			$shadow .= " $this->color";
		}

		return $shadow;
	}

	public function toEmittable(): string {
		return (string)$this;
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->offset,
			$this->blurRadius,
			$this->spreadRadius,
			$this->color,
			$this->inset ? 1 : 0,
		);
	}
}
