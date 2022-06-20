<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class Center extends BuildWidget {
	public function __construct(
		protected readonly Widget $child,
	) {}

	protected function build(RenderContext $context): Widget {
		if ($this->renderParent instanceof Flex) {
			return new FlexChild(
				child: $this->child,
				align: VerticalAlignment::Center,
			);
		}

		return new Flex(
			children: [
				$this->child,
			],
			horizontalItemAlignment: HorizontalAlignment::Center,
			verticalAlignment: VerticalAlignment::Center,
			width: Length::inPercent(100),
			height: Length::inPercent(100),
		);
	}

	public function getHashCode(): float {
		return $this->child->getHashCode();
	}
}
