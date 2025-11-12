<?php

declare(strict_types=1);

namespace Proner\PhpPimaco\Tags;

class Img
{
    private string $content;
    private ?string $margin = null;
    private string $align = 'left';
    private ?float $width = null;
    private ?float $height = null;
    private ?float $rotate = null;


    /**
     * Img constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @param float $width
     * @return $this
     */
    public function setWidth(float $width)
    {
        $this->width = $width;
        return $this;
    }

    /**
     * @param float $height
     * @return $this
     */
    public function setHeight(float $height)
    {
        $this->height = $height;
        return $this;
    }

    /**
     * @param $margin
     * @return $this
     */
    public function setMargin($margin)
    {
        if (is_array($margin)) {
            $margin = implode("mm ", $margin) . 'mm';
        } else {
            $margin = $margin . "mm";
        }
        $this->margin = $margin;
        return $this;
    }

    /**
     * @param string $align
     * @return $this
     */
    public function setAlign(string $align)
    {
        $this->align = $align;
        return $this;
    }

    /**
     * @param float $rotate
     * @return $this
     */
    public function rotate(float $rotate): self
    {
        $this->rotate = $rotate;
        return $this;
    }

    public function render()
    {
        if ($this->width !== null) {
            $styles[] = "width: {$this->width}mm";
        }

        if ($this->height !== null) {
            $styles[] = "height: {$this->height}mm";
        }

        if ($this->align == 'left') {
            $styles[] = "float: left";
        } else {
            $styles[] = "float: right";
        }

        if ($this->margin !== null) {
            $styles[] = "margin: {$this->margin}";
        }

        if (!empty($styles)) {
            $style = "style='" . implode(";", $styles) . "'";
        } else {
            $style = "";
        }

        if ($this->rotate !== null) {
            $rotate = " rotate='{$this->rotate}'";
        } else {
            $rotate = "";
        }

        return "<img {$style} src='{$this->content}'$rotate>";
    }
}
