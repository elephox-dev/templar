<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\ContentAlignment;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class Flex extends HtmlRenderWidget {
	/** @var list<Widget> */
	protected array $children = [];

	/**
	 * @param iterable<mixed, Widget> $children
	 */
	public function __construct(
		iterable $children,
		protected readonly ?HorizontalAlignment $horizontalItemAlignment = null,
		protected readonly ?VerticalAlignment $verticalAlignment = null,
		protected readonly ?ContentAlignment $contentAlignment = null,
		protected readonly ?FlexDirection $direction = null,
		protected readonly ?FlexWrap $wrap = null,
		protected readonly ?Length $rowGap = null,
		protected readonly ?Length $columnGap = null,
		protected readonly ?Length $width = null,
		protected readonly ?Length $height = null,
	) {
		assert(
			$this->verticalAlignment !== VerticalAlignment::Auto,
			"Flex widget cannot align items vertically to 'auto'",
		);

		if ($this->contentAlignment !== null && $this->wrap === FlexWrap::NoWrap) {
			trigger_error("Content alignment has no effect when flex wrap is 'no-wrap'");
		}

		foreach ($children as $child) {
			$child->renderParent = $this;

			$this->children[] = $child;
		}
	}

	protected function renderChild(RenderContext $context): string {
		return $this->renderChildren($context);
	}

	private function renderChildren(RenderContext $context): string {
		$children = '';

		$previousPositionContext = $context->positionContext;
		$context->positionContext = PositionContext::Flex;

		foreach ($this->children as $child) {
			$children .= $child->render($context);
		}

		$context->positionContext = $previousPositionContext;

		return $children;
	}

	public function renderStyle(RenderContext $context): string {
		$childStyles = $this->renderChildStyles($context);
		$myStyleContent = parent::renderStyle($context);

		if ($myStyleContent === '') {
			return $childStyles;
		}

		if ($childStyles === '') {
			return $myStyleContent;
		}

		return $myStyleContent . $childStyles;
	}

	protected function renderChildStyles(RenderContext $context): string {
		$childStyles = '';
		foreach ($this->children as $child) {
			$childStyles .= $child->renderStyle($context);
		}
		return $childStyles;
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = "display: flex;";

		if ($this->width !== null) {
			$style .= "width: $this->width;";
		}

		if ($this->height !== null) {
			$style .= "height: $this->height;";
		}

		if ($this->direction !== null) {
			$style .= "flex-direction: {$this->direction->value};";
		}

		if ($this->wrap !== null) {
			$style .= "flex-wrap: {$this->wrap->value};";
		}

		if ($this->horizontalItemAlignment !== null) {
			$style .= "justify-content: {$this->horizontalItemAlignment->value};";
		}

		if ($this->verticalAlignment !== null) {
			$style .= "align-items: {$this->verticalAlignment->value};";
		}

		if ($this->contentAlignment !== null) {
			$style .= "align-content: {$this->contentAlignment->value};";
		}

		if ($this->rowGap !== null && $this->columnGap !== null) {
			$style .= "gap: $this->rowGap $this->columnGap;";
		}
		elseif ($this->rowGap !== null) {
			$style .= "row-gap: $this->rowGap;";
		}
		elseif ($this->columnGap !== null) {
			$style .= "column-gap: $this->columnGap;";
		}

		return $style;
	}

	public function getHashCode(): int {
		return Templar::combineHashCodes(
			$this->horizontalItemAlignment?->getHashCode(),
			$this->verticalAlignment?->getHashCode(),
			$this->contentAlignment?->getHashCode(),
			$this->direction?->getHashCode(),
			$this->wrap?->getHashCode(),
			$this->rowGap?->getHashCode(),
			$this->columnGap?->getHashCode(),
		);
	}
}
