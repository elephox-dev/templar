<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\BackgroundValue;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\ColorRank;
use Elephox\Templar\EdgeInsets;
use Elephox\Templar\RenderContext;
use Elephox\Templar\TextStyle;
use Elephox\Templar\Widget;

class LinkButton extends ButtonBase {
	protected readonly Closure $linkRenderer;

	/**
	 * @param string|callable(RenderContext): string $link
	 */
	public function __construct(
		?Widget $child,
		string|callable $link,
		protected readonly ?bool $newWindow = null,
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

		$this->linkRenderer = $link instanceof Closure ? $link : static fn () => $link;
	}

	protected function getTag(): string {
		return 'a';
	}

	protected function getAttributes(RenderContext $context): array {
		$href = ($this->linkRenderer)($context);
		$attributes = [...parent::getAttributes($context), 'href' => $href];

		// TODO: parse href to determine if it is a relative or absolute URL and open absolute on other domains in new windows by default ($newWindow === null)
		if ($this->newWindow === true) {
			$attributes['target'] = '_blank';
		}

		return $attributes;
	}
}