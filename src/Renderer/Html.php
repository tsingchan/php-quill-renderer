<?php
declare(strict_types=1);

namespace DBlackborough\Quill\Renderer;

/**
 * Quill renderer, iterates over the generated content data array and creates valid HTML
 *
 * @author Dean Blackborough <dean@g3d-development.com>
 * @copyright Dean Blackborough
 * @license https://github.com/deanblackborough/php-quill-renderer/blob/master/LICENSE
 */
class Html extends Render
{
    /**
     * The generated HTML, string generated by the render method from the content array
     *
     * @var string
     */
    protected $html;

    /**
     * Renderer constructor.
     *
     * @param array $content Content data array
     */
    public function __construct(array $content)
    {
        $this->html = null;

        parent::__construct($content);
    }

    /**
     * Generate the final HTML from the contents array
     *
     * @return string
     */
    public function render() : string
    {
        foreach ($this->content as $content) {
            foreach ($content['tags'] as $tag) {
                if (array_key_exists('parent_tags', $tag) === true && $tag['parent_tags'] !== null &&
                    array_key_exists('open', $tag['parent_tags']) && $tag['parent_tags']['open'] !== null) {
                    $this->html .= $tag['parent_tags']['open'];
                }

                if (array_key_exists('open', $tag) === true && $tag['open'] !== null) {
                    $this->html .= $tag['open'];
                }
            }

            if (is_array($content['content']) === false) {
                $this->html .= $content['content'];
            } else {
                $this->html .= '<img src="' . $content['content']['image'] . '" />';
            }

            foreach (array_reverse($content['tags']) as $tag) {
                if (array_key_exists('close', $tag) === true && $tag['close'] !== null) {
                    $this->html .= $tag['close'];
                }

                if (array_key_exists('parent_tags', $tag) === true && $tag['parent_tags'] !== null &&
                    array_key_exists('close', $tag['parent_tags']) && $tag['parent_tags']['close'] !== null) {
                    $this->html .= $tag['parent_tags']['close'];
                }
            }
        }

        return str_replace("\n", '', $this->html);
    }
}