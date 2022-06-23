<?php
declare(strict_types=1);

namespace Elephox\Templar\Foundation;

use Elephox\Templar\Border;
use Elephox\Templar\BorderRadius;
use Elephox\Templar\BoxFit;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\HtmlRenderWidget;
use Elephox\Templar\RenderContext;

class Image extends HtmlRenderWidget {
	public function __construct(
		protected readonly string $src,
		protected readonly string $alt = '',
		protected readonly ?Border $border = null,
		protected readonly ?BorderRadius $borderRadius = null,
		protected readonly BoxFit $fit = BoxFit::Fill,
		protected readonly ?float $opacity = null,
	) {}

	protected function getTag(): string {
		return 'img';
	}

	protected function getAttributes(RenderContext $context): array {
		return [...parent::getAttributes($context), 'src' => $this->src, 'alt' => $this->alt];
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->src,
			$this->alt,
		);
	}

	protected function renderContent(RenderContext $context): string {
		return '';
	}

	protected function renderStyleContent(RenderContext $context): string {
		$style = parent::renderStyleContent($context);

		//$style .= "background-image: url($this->src);background-repeat: no-repeat;";
		$style .= match ($this->fit) {
			BoxFit::Fill => 'object-fit: fill;',
			BoxFit::Contain => 'object-fit: contain;',
			BoxFit::Cover => 'object-fit: cover;',
			BoxFit::ScaleDown => 'object-fit: scale-down;',
		};

		if ($this->border !== null) {
			$style .= $this->border->toEmittable();
		}

		if ($this->borderRadius !== null) {
			$style .= $this->borderRadius->toEmittable();
		}

		return $style;
	}
}