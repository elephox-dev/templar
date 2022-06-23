<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BoxShadow;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Length;
use Elephox\Templar\PositionContext;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\CrossAxisAlignment;
use Elephox\Templar\Widget;

class AppBar extends BuildWidget {
	public function __construct(
		protected readonly ?string $title = null,
	) {}

	protected function build(RenderContext $context): Widget {
		$elements = [];

		if ($this->title !== null) {
			$elements[] = new Text(
				text: $this->title,
				style: new TextStyle(
					size: Length::inRem(1.1),
					weight: 'bold',
					color: $context->colorScheme->onPrimary
				),
			);
		}

		return new Container(
			child: new Row(
				children: $elements,
				crossAxisAlignment: CrossAxisAlignment::Center,
			),
			background: $context->colorScheme->primary,
			shadows: BoxShadow::fromElevation(8)->withAmbient(),
			padding: EdgeInsets::symmetric(horizontal: Length::inPx(10)),
			position: PositionContext::Fixed,
			width: Length::inPercent(100),
			height: Sizes::NavbarHeight(),
			top: 0,
			left: 0,
			right: 0,
		);
	}
}