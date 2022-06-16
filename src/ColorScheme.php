<?php
declare(strict_types=1);

namespace Elephox\Templar;

class ColorScheme {
	public function __construct(
		public readonly Color $primary,
		public readonly Color $secondary,
		public readonly Color $tertiary,
		public readonly Color $background,
		public readonly Color $foreground,
		public readonly Color $onPrimary,
		public readonly Color $onSecondary,
		public readonly Color $onTertiary,
		public readonly Color $divider,
	) {}
}
