<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Color;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class Body extends TextStyleApplicator {
	use HasSingleRenderChild;

	public function __construct(
		Widget $child,
		?TextStyle $textStyle = null,
		protected null|Color $color = null,
	) {
		parent::__construct($child, $textStyle);
	}

	protected function getTag(): string {
		return 'body';
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		if ($this->color !== null) {
			$style .= "background-color: $this->color;";
		}

		return $style;
	}
}
