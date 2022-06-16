<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasRenderedStyle;
use Elephox\Templar\RenderContext;

class FullscreenDocument extends Document {
	use HasRenderedStyle;

	protected function renderStyle(RenderContext $context): string {
		return 'margin: 0; padding: 0; width: 100%; height: 100%;';
	}
}
