<?php
declare(strict_types=1);

namespace Elephox\Templar;

readonly class SvgIconData implements IconData {
	public function __construct(
		protected string $name,
		protected string $svg,
	) {}

	public function __toString(): string {
		return $this->svg;
	}

	public function toEmittable(): string {
		return $this->svg;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash($this->svg);
	}

	public function getStyleSelector(): string {
		return 'svg';
	}

	public function renderStyleContent(): string {
		return 'display: block;';
	}

	public function getName(): string {
		return $this->name;
	}
}