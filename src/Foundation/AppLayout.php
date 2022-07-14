<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\DocumentMeta;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\Length;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Widget;

class AppLayout extends BuildWidget {
	public function __construct(
		protected readonly Widget $body,
		protected readonly ?string $title = null,
		protected readonly ?AppBar $navBar = null,
	) {}

	protected function build(RenderContext $context): Widget {
		$context->meta->title ??= $this->title;

		$padding = EdgeInsets::all(Length::inRem(1));

		if ($this->navBar === null) {
			$bodyContent = new Padding(
				child: $this->body,
				padding: $padding,
			);
		} else {
			$bodyContent = new Column(
				children: [
					$this->navBar,
					new Padding(
						$this->body,
						padding: $padding->add(
							top: Sizes::NavbarHeight()
						),
					),
				],
			);
		}

		return new FullscreenDocument(
			head: new Head(),
			body: new FullscreenBody(
				child: $bodyContent,
			),
		);
	}
}