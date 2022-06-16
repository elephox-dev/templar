<?php
declare(strict_types=1);

namespace Elephox\Templar;

class TextStyle {
	public function __construct(
		public string $font,
		public Length $size,
		public int $weight,
	) {}
}
