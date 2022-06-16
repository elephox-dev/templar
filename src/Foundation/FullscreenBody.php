<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;

class FullscreenBody extends Body {
	public function render(RenderContext $context): string {
		assert($context->parent instanceof FullscreenDocument, "FullscreenBody must be rendered inside of FullscreenDocument");

		return parent::render($context);
	}

	protected function renderStyleContent(RenderContext $context): string {
		return 'margin: 0; padding: 0; width: 100%; height: 100%;';
	}
}
