<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\ContentAlignment;
use Elephox\Templar\FlexDirection;
use Elephox\Templar\FlexWrap;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\Length;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class Wrap extends BuildWidget {
	public function __construct(
		protected readonly iterable $children,
		protected readonly ?HorizontalAlignment $horizontalItemAlignment = null,
		protected readonly ?VerticalAlignment $verticalAlignment = null,
		protected readonly ?ContentAlignment $contentAlignment = null,
		protected readonly bool $reverse = false,
		protected readonly bool $shrinkWrap = false,
	) {}

	protected function build(): Widget {
		return new Flex(
			children: $this->children,
			horizontalItemAlignment: $this->horizontalItemAlignment,
			verticalAlignment: $this->verticalAlignment,
			contentAlignment: $this->contentAlignment,
			direction: $this->reverse ? FlexDirection::RowReverse : FlexDirection::Row,
			wrap: FlexWrap::Wrap,
			width: $this->shrinkWrap ? null : Length::inPercent(100),
			height: Length::inPercent(100),
		);
	}
}