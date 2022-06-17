<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\Length;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class Row extends BuildWidget {
	/**
	 * @param iterable<mixed, Widget> $children
	 */
	public function __construct(
		protected readonly iterable $children,
		protected readonly ?HorizontalAlignment $horizontalItemAlignment = null,
		protected readonly ?VerticalAlignment $verticalAlignment = null,
		protected readonly bool $reverse = false,
	) {}

	protected function build(): Widget {
		return new Flex(
			children: $this->children,
			horizontalItemAlignment: $this->horizontalItemAlignment,
			verticalAlignment: $this->verticalAlignment,
			direction: $this->reverse ? FlexDirection::RowReverse : FlexDirection::Row,
			wrap: FlexWrap::NoWrap,
			width: Length::inPercent(100),
			height: Length::inPercent(100),
		);
	}
}
