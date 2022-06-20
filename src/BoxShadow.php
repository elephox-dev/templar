<?php
declare(strict_types=1);

namespace Elephox\Templar;

class BoxShadow implements Emittable {
	public static function ambient(int $elevation, ?Color $color = null): AmbientBoxShadow {
		return new AmbientBoxShadow(
			$elevation,
			$color
		);
	}

	public static function fromElevation(int $elevation, ?Color $color = null): ElevatedBoxShadow {
		return new ElevatedBoxShadow(
			$elevation,
			$color
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
		return (string) $this;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->offset,
			$this->blurRadius,
			$this->spreadRadius,
			$this->color,
			$this->inset,
		);
	}
}
