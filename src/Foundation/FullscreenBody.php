<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class FullscreenBody extends Body {
	public function __construct(
		Widget $child,
		?TextStyle $textStyle = null,
	) {
		parent::__construct($child, $textStyle);
	}

	public function render(RenderContext $context): string {
		assert(
			$context->parent instanceof FullscreenDocument,
			"FullscreenBody must be rendered inside of FullscreenDocument"
		);

		return parent::render($context);
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		return "{$style}margin: 0; padding: 0;";
	}
}
