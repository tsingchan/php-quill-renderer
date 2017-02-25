<?php

require_once __DIR__ . '../../src/DBlackborough/Quill/Renderer.php';

final class ContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \DBlackborough\Quill\Renderer
     */
    private $renderer;

    public function setUp()
    {
        $this->renderer = new \DBlackborough\Quill\Renderer();
    }

    public function testDeltasInValid()
    {
        $deltas = '{"ops":[{"insert":"Lorem ipsum dolor sit amet}]}';
        $this->assertFalse($this->renderer->load($deltas), __METHOD__ . ' failed');
    }

    public function testDeltasValid()
    {
        $deltas = '{"ops":[{"insert":"Lorem ipsum dolor sit amet"}]}';
        $this->assertTrue($this->renderer->load($deltas), __METHOD__ . ' failed');
    }

    public function testParagraphAroundOneInsert()
    {
        $deltas = '{"ops":[{"insert":"Lorem ipsum dolor sit amet"}]}';
        $expected = '<p>Lorem ipsum dolor sit amet</p>';
        $this->renderer->load($deltas);
        $this->assertEquals($expected, $this->renderer->toHtml(), __METHOD__ . ' failed');
    }

    public function testContainerAttributeOptionSet()
    {
        $this->assertTrue($this->renderer->setOption('container', 'div'), __METHOD__ . ' failed');
    }

    public function testDivAAroundOneInsert()
    {
        $deltas = '{"ops":[{"insert":"Lorem ipsum dolor sit amet"}]}';
        $expected = '<div>Lorem ipsum dolor sit amet</div>';
        $this->renderer->load($deltas);
        $this->renderer->setOption('container', 'div');
        $this->assertEquals($expected, $this->renderer->toHtml(), __METHOD__ . ' failed');
    }
}
