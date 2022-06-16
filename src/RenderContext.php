<?php
declare(strict_types=1);

namespace Elephox\Templar;

class RenderContext {
	public function __construct(
		public ColorScheme $colorScheme,
		public TextStyle $textStyle,
		public ?ColorScheme $darkColorScheme = null,
		public ?DocumentMeta $documentMeta = null,
		public PositionContext $positionContext = PositionContext::Static,
		public ?Widget $parent = null,
	) {}
}
