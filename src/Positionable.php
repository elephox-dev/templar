<?php
declare(strict_types=1);

namespace Elephox\Templar;

interface Positionable {
	public function getContext(): PositionContext;

	public function maybeSetContext(PositionContext $context): void;

	public function getTop(): ?EmittableLength;

	public function getLeft(): ?EmittableLength;

	public function getRight(): ?EmittableLength;

	public function getBottom(): ?EmittableLength;
}