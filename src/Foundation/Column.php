<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\Length;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class Column extends BuildWidget {
	/**
	 * @param iterable<mixed, Widget> $children
	 */
	public function __construct(
		protected readonly iterable $children,
		protected readonly ?MainAxisAlignment $mainAxisAlignment = null,
		protected readonly ?CrossAxisAlignment $crossAxisAlignment = null,
		protected readonly bool $reverse = false,
		protected readonly bool $shrinkWrap = false,
		protected readonly ?Length $gap = null,
	) {}

	protected function build(RenderContext $context): Widget {
		return new Flex(
			children: $this->children,
			mainAxisAlignment: $this->mainAxisAlignment,
			crossAxisAlignment: $this->crossAxisAlignment,
			direction: $this->reverse ? FlexDirection::ColumnReverse : FlexDirection::Column,
			wrap: FlexWrap::NoWrap,
			rowGap: $this->gap,
			width: $this->shrinkWrap ? null : Length::inPercent(100),
			height: $this->shrinkWrap ? null : Length::inPercent(100),
		);
	}
}
