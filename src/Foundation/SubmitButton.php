<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\BackgroundValue;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\ColorRank;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class SubmitButton extends ButtonBase {
	public function __construct(
		?Widget $child,
		null|BackgroundValue $background = null,
		?TextStyle $textStyle = null,
		?EdgeInsets $padding = null,
		?BorderRadius $borderRadius = null,
		ColorRank $rank = ColorRank::Primary,
	) {
		parent::__construct(
			$child,
			$background,
			$textStyle,
			$padding,
			$borderRadius,
			$rank
		);

		if ($this->child !== null) {
			$this->child->renderParent = $this;
		}
	}

	protected function getAttributes(RenderContext $context): array {
		return [...parent::getAttributes($context), 'type' => 'submit'];
	}
}