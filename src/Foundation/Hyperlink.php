<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Closure;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HyperlinkRel;
use Elephox\Templar\ReferrerPolicy;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Target;
use Elephox\Templar\TextStyle;

class Hyperlink extends TextSpan {
	protected Closure $href;

	public function __construct(
		string $text,
		string|callable $href,
		?TextStyle $style = null,
		iterable $children = [],
		protected ?TextStyle $visitedStyle = null,
		protected ?TextStyle $activeStyle = null,
		protected ?TextStyle $hoverStyle = null,
		protected ?TextStyle $focusStyle = null,
		protected ?string $downloadFilename = null,
		protected ?string $hreflang = null,
		protected ?string $media = null,
		protected ?ReferrerPolicy $referrerPolicy = null,
		protected ?HyperlinkRel $rel = null,
		protected ?Target $target = null,
		protected ?string $type = null,
	) {
		parent::__construct(
			$text,
			$style,
			$children
		);

		$this->href =
			static fn (RenderContext $context) => is_string($href) ? $href : $href($context);
	}

	protected function getTag(): string {
		return 'a';
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->style,
			$this->visitedStyle,
			$this->activeStyle,
			$this->hoverStyle,
			$this->focusStyle,
		);
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		if ($this->visitedStyle !== null) {
			$style .= "} .{$this->getStyleClassName()}:visited {" . $this->renderTextStyle(
					$this->visitedStyle,
					$context
				);
		}

		if ($this->activeStyle !== null) {
			$style .= "} .{$this->getStyleClassName()}:active {" . $this->renderTextStyle(
					$this->activeStyle,
					$context
				);
		}

		if ($this->hoverStyle !== null) {
			$style .= "} .{$this->getStyleClassName()}:hover {" . $this->renderTextStyle(
					$this->hoverStyle,
					$context
				);
		}

		if ($this->focusStyle !== null) {
			$style .= "} .{$this->getStyleClassName()}:focus {" . $this->renderTextStyle(
					$this->focusStyle,
					$context
				);
		}

		return $style;
	}

	protected function getAttributes(RenderContext $context): array {
		$attr = parent::getAttributes($context);

		$attr['href'] = ($this->href)($context);

		if ($this->downloadFilename !== null) {
			$attr['download'] = $this->downloadFilename;
		}

		if ($this->hreflang !== null) {
			$attr['hreflang'] = $this->hreflang;
		}

		if ($this->media !== null) {
			$attr['media'] = $this->media;
		}

		if ($this->referrerPolicy !== null) {
			$attr['referrerpolicy'] = $this->referrerPolicy->value;
		}

		if ($this->rel !== null) {
			$attr['rel'] = $this->rel->value;
		}

		if ($this->target !== null) {
			$attr['target'] = $this->target->value;
		}

		if ($this->type !== null) {
			$attr['type'] = $this->type;
		}

		return $attr;
	}
}