<?php
declare(strict_types=1);

namespace Elephox\Templar;

trait RendersPadding {
	protected function renderPadding(
		EdgeInsets $padding,
		CompoundLength $width,
		CompoundLength $height
	): string {
		$style = "";

		if ($padding->left !== null) {
			$style .= "padding-left: {$padding->left->toEmittable()};";
			$width->concat($padding->left);
		}

		if ($padding->right !== null) {
			$style .= "padding-right: {$padding->right->toEmittable()};";
			$width->concat($padding->right);
		}

		if ($padding->top !== null) {
			$style .= "padding-top: {$padding->top->toEmittable()};";
			$height->concat($padding->top);
		}

		if ($padding->bottom !== null) {
			$style .= "padding-bottom: {$padding->bottom->toEmittable()};";
			$height->concat($padding->bottom);
		}

		return $style;
	}
}