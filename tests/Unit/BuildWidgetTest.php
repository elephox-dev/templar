<?php
declare(strict_types=1);

namespace Elephox\Templar\Tests\Unit;

use Elephox\Templar\BuildWidget;
use Elephox\Templar\Foundation\Text;
use Elephox\Templar\HashBuilder;
use Elephox\Templar\RenderContext;
use Elephox\Templar\Templar;
use Elephox\Templar\ThrowableWidget;
use Elephox\Templar\Widget;
use RuntimeException;

class SimpleBuildWidget extends BuildWidget {
	public function build(RenderContext $context): Widget {
		return new Text('');
	}
}

class BuildWidgetWithProperties extends BuildWidget {
	public function __construct(
		private readonly string $property1,
	) {}

	public function build(RenderContext $context): Widget {
		return new Text($this->property1);
	}

	public function getHashCode(): float {
		return HashBuilder::buildHash($this->property1);
	}
}

class ThrowsWhenRenderedBuildWidget extends BuildWidget {
	protected function build(RenderContext $context): Widget {
		throw new RuntimeException('This widget throws when rendered.');
	}
}

it(
	'has the same hash code as other instances',
	static function () {
		$widgetA = new SimpleBuildWidget();
		$widgetB = new SimpleBuildWidget();

		$instHashA = $widgetA->getHashCode();
		$instHashB = $widgetB->getHashCode();

		expect($instHashA)->toEqual($instHashB);
	}
);

it(
	'has different hash code when properties are changed',
	static function () {
		$widgetA = new BuildWidgetWithProperties('a');
		$widgetB = new BuildWidgetWithProperties('b');

		$instHashA = $widgetA->getHashCode();
		$instHashB = $widgetB->getHashCode();

		expect($instHashA)->not->toEqual($instHashB);
	}
);

it(
	'builds a ThrowableWidget when an exception occurs',
	static function () {
		$container = new ThrowsWhenRenderedBuildWidget();

		$context = Templar::getDefaultRenderContext();
		$renderedWidget = $container->safeBuild($context);

		expect($renderedWidget)->toBeInstanceOf(ThrowableWidget::class);
	}
);