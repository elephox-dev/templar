<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\HorizontalAlignment;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class Center extends BuildWidget {
	public function __construct(
		private readonly Widget $child,
	) {}

	protected function build(): Widget {
		return new Flex(
			children: [
				$this->child,
			],
			horizontalItemAlignment: HorizontalAlignment::Center,
			verticalAlignment: VerticalAlignment::Center,
		);
	}
}
