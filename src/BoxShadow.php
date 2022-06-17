<?php
declare(strict_types=1);

namespace Elephox\Templar;

class BoxShadow implements Emittable {
	public static function fromElevation(int $elevation, ?Color $color = null): BoxShadow {
		assert($elevation % 4 === 0, "Elevation must be a multiple of 4, was $elevation");

		return new BoxShadow(
			offset: new Offset(y: $elevation / 4),
			blurRadius: $elevation,
			spreadRadius: -$elevation / 4,
			color: $color,
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
			'Blur radius must be non-negative.'
		);
		assert(
			$this->spreadRadius === null || $this->blurRadius !== null,
			'Spread radius requires blur radius to be set.'
		);

		// TODO: check length units are possible for each property (e.g. % for blur radius?)
	}

	public function __toString(): string {
		$shadow = "{$this->offset->x} {$this->offset->y}";

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
			$this->offsetX,
			$this->offsetY,
			$this->blurRadius,
			$this->spreadRadius,
			$this->color,
			$this->inset ? 1 : 0,
		);
	}
}