<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class Column extends BuildWidget {
	/**
	 * @param iterable<mixed, Widget> $children
	 */
	public function __construct(
		protected readonly iterable $children,
		protected readonly ?HorizontalAlignment $horizontalItemAlignment = null,
		protected readonly ?VerticalAlignment $verticalAlignment = null,
		protected readonly bool $reverse = false,
		protected readonly bool $shrinkWrap = false,
	) {}

	protected function build(RenderContext $context): Widget {
		return new Flex(
			children: $this->children,
			horizontalItemAlignment: $this->horizontalItemAlignment,
			verticalAlignment: $this->verticalAlignment,
			direction: $this->reverse ? FlexDirection::ColumnReverse : FlexDirection::Column,
			wrap: FlexWrap::NoWrap,
			width: $this->shrinkWrap ? null : Length::inPercent(100),
			height: Length::inPercent(100),
		);
	}
}
