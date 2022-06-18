<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BoxShadow;
use Elephox\Templar\BuildWidget;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Length;
use Elephox\Templar\PositionContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\VerticalAlignment;
use Elephox\Templar\Widget;

class NavigationBar extends BuildWidget {
	public function __construct(
		protected readonly ?string $title = null,
	) {}

	protected function build(): Widget {
		$elements = [];

		if ($this->title !== null) {
			$elements[] = new Text(
				text: $this->title,
				style: new TextStyle(
					size: Length::inRem(1.1),
					weight: 'bold',
				),
			);
		}

		return new Container(
			child: new Row(
				children: $elements,
				verticalAlignment: VerticalAlignment::Center,
			),
			color: Colors::SkyBlue(),
			shadows: BoxShadow::fromElevation(8)->withAmbient(),
			padding: EdgeInsets::symmetric(horizontal: Length::inPx(10)),
			position: PositionContext::Fixed,
			height: Sizes::NavbarHeight(),
		);
	}
}