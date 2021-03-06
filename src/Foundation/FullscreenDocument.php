<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;

class FullscreenDocument extends Document {
	public function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		return $style . 'margin: 0; padding: 0; width: 100%; height: 100%;';
	}
}
