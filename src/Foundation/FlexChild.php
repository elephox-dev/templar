<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class FlexChild extends HtmlRenderWidget {
	use HasSingleRenderChild;

	public function __construct(
		protected readonly ?Widget $child,
		private readonly ?int $order = null,
		private readonly ?int $grow = null,
		private readonly ?int $shrink = null,
		private readonly null|Length|string $basis = null,
		private readonly ?VerticalAlignment $align = null,
	) {
		if ($child !== null) {
			$child->renderParent = $this;
		}
	}

	public function render(RenderContext $context): string {
		assert(
			$context->positionContext === PositionContext::Flex,
			"FlexChild cannot be rendered outside of Flex container",
		);

		return parent::render($context);
	}

	protected function renderStyleContent(RenderContext $context): string {
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

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->child->getHashCode(),
			$this->order,
			$this->grow,
			$this->shrink,
			$this->basis !== null ? ($this->basis instanceof Length
				? $this->basis->getHashCode()
				: hexdec(
					substr(
						md5($this->basis),
						0,
						8,
					)
				)) : null,
			$this->align?->getHashCode(),
		);
	}
}
