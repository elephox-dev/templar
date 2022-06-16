<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\Length;
use Elephox\Templar\Widget;

class Row extends BuildWidget {
	/**
	 * @param iterable<mixed, Widget> $children
	 */
	public function __construct(
		private readonly iterable $children,
	) {}

	protected function build(): Widget {
		return new Flex(
			children: $this->children,
			direction: FlexDirection::Row,
			wrap: FlexWrap::NoWrap,
			width: Length::inPercent(100),
		);
	}
}
