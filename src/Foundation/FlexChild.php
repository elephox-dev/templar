<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasRenderedStyle;
use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderException;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class FlexChild extends HtmlRenderWidget
{
	use HasSingleRenderChild;
	use HasRenderedStyle;

	public function __construct(
		private readonly Widget $child,
		private readonly ?int $order = null,
		private readonly ?int $grow = null,
		private readonly ?int $shrink = null,
		private readonly null|Length|string $basis = null,
		private readonly ?VerticalAlignment $align = null,
	) {}

	public function render(RenderContext $context): string
	{
		if ($context->positionContext !== PositionContext::Flex) {
			throw new RenderException("FlexChild cannot be rendered outside of Flex container");
		}

		return parent::render($context);
	}

	private function renderStyle(): string
	{
		$style = "";

		if ($this->order !== null) {
			$style .= "order: $this->order;";
		}

		if ($this->grow !== null) {
			$style .= "flex-grow: $this->grow;";
		}

		if ($this->shrink !== null) {
			$style .= "flex-shrink: $this->shrink;";
		}

		if ($this->basis !== null) {
			$style .= "flex-basis: $this->basis;";
		}

		if ($this->align !== null) {
			$style .= "align-self: {$this->align->value};";
		}

		return $style;
	}
}
