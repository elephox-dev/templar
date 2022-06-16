<?php
declare(strict_types=1);

namespace Elephox\Templar;

class TextStyle {
	public function __construct(
		public ?string $font = null,
		public ?Length $size = null,
		public ?int $weight = null,
		public ?TextAlign $align = null,
	) {}

	public function overwriteFrom(?TextStyle $other): TextStyle {
		if ($other === null) {
			return $this;
		}

		return new TextStyle(
			$other->font ?? $this->font,
			$other->size ?? $this->size,
			$other->weight ?? $this->weight,
			$other->align ?? $this->align,
		);
	}
}
