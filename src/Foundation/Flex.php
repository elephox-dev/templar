<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\RenderContext;
use Elephox\Templar\RenderWidget;
use Elephox\Templar\BuildWidget;

class Flex extends RenderWidget
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
	) {
		assert($this->verticalAlignment !== VerticalAlignment::Auto, "Flex widget cannot align items vertically to 'auto'");
		assert($this->contentAlignment === null || $this->wrap !== FlexWrap::NoWrap, "Content alignment has no effect when flex wrap is 'no-wrap'");
	}

	public function render(RenderContext $context): string
	{
		return <<<HTML
<div style="{$this->renderStyle()}">
	{$this->renderChildren($context)}
</div>
HTML;
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

	private function renderStyle(): string
	{
		$style = "display: flex;height: 100%;width: 100%;";

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
}
