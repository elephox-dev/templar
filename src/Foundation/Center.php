<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\MainAxisAlignment;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\Widget;

class Center extends BuildWidget {
	public function __construct(
		protected readonly Widget $child,
	) {}

	protected function build(RenderContext $context): Widget {
		if ($this->renderParent instanceof Flex) {
			return new FlexChild(
				child: $this->child,
				align: CrossAxisAlignment::Center,
			);
		}

		return new Flex(
			children: [
				$this->child,
			],
			mainAxisAlignment: MainAxisAlignment::Center,
			crossAxisAlignment: CrossAxisAlignment::Center,
			width: Length::inPercent(100),
			height: Length::inPercent(100),
		);
	}

	public function getHashCode(): float {
		return $this->child->getHashCode();
	}
}
