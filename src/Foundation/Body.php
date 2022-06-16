<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\HasSingleRenderChild;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class Body extends TextStyleApplicator {
	use HasSingleRenderChild;

	public function __construct(
		Widget $child,
		?TextStyle $textStyle = null,
	) {
		parent::__construct($child, $textStyle);
	}

	protected function getTag(): string {
		return 'body';
	}
}
