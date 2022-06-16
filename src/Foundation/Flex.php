<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\FlexContentAlignment;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\Length;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\VerticalAlignment;

class Flex extends HtmlRenderWidget
{
	/**
	 * @param iterable<mixed, BuildWidget> $children
	 */
	public function __construct(
		private readonly iterable $children,
		private readonly ?HorizontalAlignment $horizontalItemAlignment = null,
		private readonly ?VerticalAlignment $verticalAlignment = null,
		private readonly ?FlexContentAlignment $contentAlignment = null,
		private readonly ?FlexDirection $direction = null,
		private readonly ?FlexWrap $wrap = null,
		private readonly ?Length $rowGap = null,
		private readonly ?Length $columnGap = null,
		private readonly ?Length $width = null,
		private readonly ?Length $height = null,
	) {
		assert($this->verticalAlignment !== VerticalAlignment::Auto, "Flex widget cannot align items vertically to 'auto'");
		assert($this->contentAlignment === null || $this->wrap !== FlexWrap::NoWrap, "Content alignment has no effect when flex wrap is 'no-wrap'");
	}

	protected function renderChild(RenderContext $context): string {
		return $this->renderChildren($context);
	}

	private function renderChildren(RenderContext $context): string
	{
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
		$myStyleContent = $this->renderStyleContent($context);
		$childStyles = $this->renderChildStyles($context);

		return <<<CSS
.{$this->getStyleClassName()} {
	$myStyleContent
}
$childStyles
CSS;
	}

	protected function renderChildStyles(RenderContext $context): string {
		$childStyles = '';
		foreach ($this->children as $child) {
			$childStyles .= $child->renderStyle($context);
		}
		return $childStyles;
	}

	protected function renderStyleContent(RenderContext $context): string
	{
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
		} elseif ($this->rowGap !== null) {
			$style .= "row-gap: $this->rowGap;";
		} elseif ($this->columnGap !== null) {
			$style .= "column-gap: $this->columnGap;";
		}

		return $style;
	}

	public function getHashCode(): int {
		$hashCodes = [];
		foreach ($this->children as $child) {
			$hashCodes[] = $child->getHashCode();
		}
		$hashCodes[] = $this->horizontalItemAlignment?->getHashCode();
		$hashCodes[] = $this->verticalAlignment?->getHashCode();
		$hashCodes[] = $this->contentAlignment?->getHashCode();
		$hashCodes[] = $this->direction?->getHashCode();
		$hashCodes[] = $this->wrap?->getHashCode();
		$hashCodes[] = $this->rowGap?->getHashCode();
		$hashCodes[] = $this->columnGap?->getHashCode();

		return Templar::combineHashCodes(...$hashCodes);
	}
}
