<?php
declare(strict_types=1);

namespace Elephox\Templar;

class RenderContext {
	public function __construct(
		public DocumentMeta $meta,
		public ColorScheme $colorScheme,
		public ?ColorScheme $darkColorScheme = null,
		public ?TextStyle $textStyle = null,
		public PositionContext $positionContext = PositionContext::Static,
		public array $renderedClasses = [],
	) {}

	public function withColorScheme(
		ColorScheme $colorScheme,
		?ColorScheme $darkColorScheme = null
	): RenderContext {
		return new RenderContext(
			$this->meta,
			$colorScheme,
			$darkColorScheme ?? $this->darkColorScheme,
			$this->textStyle,
			$this->positionContext,
			$this->renderedClasses,
		);
	}

	public function with(
		?DocumentMeta $meta = null,
		?ColorScheme $colorScheme = null,
		?ColorScheme $darkColorScheme = null,
		?TextStyle $textStyle = null,
		?PositionContext $positionContext = null,
		?array $renderedClasses = [],
	): RenderContext {
		return new RenderContext(
			$meta ?? $this->meta,
			$colorScheme ?? $this->colorScheme,
			$darkColorScheme ?? $this->darkColorScheme,
			$textStyle ?? $this->textStyle,
			$positionContext ?? $this->positionContext,
			$renderedClasses ?? $this->renderedClasses,
		);
	}

	public function withFallback(
		?DocumentMeta $meta = null,
		?ColorScheme $colorScheme = null,
		?ColorScheme $darkColorScheme = null,
		?TextStyle $textStyle = null,
		?PositionContext $positionContext = null,
		?array $renderedClasses = [],
	): RenderContext {
		return new RenderContext(
			$this->meta ?? $meta,
			$this->colorScheme ?? $colorScheme,
			$this->darkColorScheme ?? $darkColorScheme,
			$this->textStyle ?? $textStyle,
			$this->positionContext ?? $positionContext,
			$this->renderedClasses ?? $renderedClasses,
		);
	}
}
