<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Widget;

class Flex extends Widget
{
	/**
	 * @param iterable<mixed, Widget> $children
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

	public function render(): string
	{
		return <<<HTML
<div style="{$this->renderStyle()}">
	{$this->renderChildren()}
</div>
HTML;
	}

	private function renderChildren(): string
	{
		$children = '';

		foreach ($this->children as $child) {
			$children .= $child->render();
		}

		return $children;
	}

	private function renderStyle(): string
	{
		$style = "display: flex;";

		if ($this->direction !== null) {
			$style .= "flex-direction: {$this->direction->value};";
		}

		if ($this->wrap !== null) {
			$style .= "flex-wrap: {$this->wrap->value};";
		}

		if ($this->horizontalItemAlignment !== null) {
			$style .= "justify-content: $this->horizontalItemAlignment;";
		}

		if ($this->verticalAlignment !== null) {
			$style .= "align-items: $this->verticalAlignment;";
		}

		if ($this->contentAlignment !== null) {
			$style .= "align-content: $this->contentAlignment;";
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
