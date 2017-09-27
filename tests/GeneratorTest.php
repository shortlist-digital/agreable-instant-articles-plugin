<?php

use PHPUnit\Framework\TestCase;
use AgreableInstantArticlesPlugin\Generators\Embed;

class GeneratorTest extends TestCase
{
    public function setUp()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../app/Generators/views');
        $this->twig = new Twig_Environment($loader);
    }

    private function remove_spaces($text)
    {
        return str_replace([' ', "\n"], '', $text);
    }

    public function test_embed()
    {
        $widget['caption'] = 'Test caption';

        $timber = \Mockery::mock('alias:Timber');
        $timber->shouldReceive('compile')
            ->andReturnUsing(function() use ($widget) {
                return $this->twig->render('embed.twig', $widget);
            });

        $expected = '<figureclass="op-interactive"><iframe class="no-margin">
            </iframe>
            <figcaption>
            Test caption
            </figcaption>
            </figure>';

        $obj = new Embed();
        $this->assertSame(
            $this->remove_spaces($expected),
            $this->remove_spaces($obj->get($widget))
        );
    }
}
