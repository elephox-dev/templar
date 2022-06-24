<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\EmittableLength;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\IconData;
use Elephox\Templar\RenderContext;

class Icon extends HtmlRenderWidget {
	public function __construct(
		protected readonly IconData $iconData,
		protected readonly null|int|float|EmittableLength $width = null,
		protected readonly null|int|float|EmittableLength $height = null,
	) {}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->iconData,
			$this->width,
			$this->height,
		);
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		if ($this->width !== null) {
			$style .= 'width: ' . $this->width->toEmittable() . ';';
		}

		if ($this->height !== null) {
			$style .= 'height: ' . $this->height->toEmittable() . ';';
		}

		return $style;
	}

	public function renderCss(string $className, string $content): string {
		$iconStyleCss = $this->renderIconDataCss(
			$className,
			$this->iconData->getStyleSelector(),
			$this->iconData->renderStyleContent(),
		);

		return ".$className { $content } $iconStyleCss";
	}

	public function renderIconDataCss(
		string $className,
		string $selector,
		string $content
	): string {
		return ".$className > $selector { $content }";
	}

	protected function renderContent(RenderContext $context): string {
		return $this->iconData->toEmittable();
	}
}