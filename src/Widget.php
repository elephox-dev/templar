<?php

namespace Elephox\Templar;

abstract class Widget implements Hashable {
	abstract protected function build(): Widget;

	abstract public function render(RenderContext $context): string;

	public function getStyleClassName(): string {
		return str_replace('\\', '-', strtolower(static::class)) . '-' . $this->getHashCode();
	}

	abstract public function renderStyle(RenderContext $context): string;
}
