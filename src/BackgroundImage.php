<?php
declare(strict_types=1);

namespace Elephox\Templar;

class BackgroundImage implements BackgroundValue {
	public function __construct(
		protected readonly string $src,
		protected readonly BoxFit $fit = BoxFit::Fill,
	) {}

	public function __toString(): string {
		return "url($this->src);background-repeat: no-repeat;background-position: 50% 50%;" .
			match ($this->fit) {
				BoxFit::Contain => 'background-size: contain;',
				BoxFit::Cover => 'background-size: cover;',
				BoxFit::Fill => 'background-size: 100% 100%;',
				BoxFit::ScaleDown => 'background-size: 100% auto;',
			};
	}

	public function toEmittable(): string {
		return (string)$this;
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash(
			$this->src,
			$this->fit,
		);
	}
}