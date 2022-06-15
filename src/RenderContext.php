<?php
declare(strict_types=1);

namespace Elephox\Templar;

use Elephox\Templar\Foundation\ColorScheme;
use Elephox\Templar\Foundation\DocumentMeta;
use Elephox\Templar\Foundation\PositionContext;
use Elephox\Templar\Foundation\TextStyle;

class RenderContext {
	public function __construct(
		public ColorScheme $colorScheme,
		public TextStyle $textStyle,
		public ?ColorScheme $darkColorScheme = null,
		public ?DocumentMeta $documentMeta = null,
		public PositionContext $positionContext = PositionContext::Static,
	) {}
}
