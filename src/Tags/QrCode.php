<?php

declare(strict_types=1);

namespace Proner\PhpPimaco\Tags;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeNone;
use Endroid\QrCode\Writer\PngWriter;

class QrCode
{
    private int $size = 100;
    private ?string $label = null;
    private int $labelFontSize = 12;
    private float $padding = 0;
    private ?int $margin = null;
    private string $align = 'left';
    private string $content;
    private string $br = '';

    /**
     * QrCode constructor.
     * @param string $content
     * @param string|null $typeCode
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize(int $size)
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param int $labelFontSize
     * @return $this
     */
    public function setLabelFontSize(int $labelFontSize)
    {
        $this->labelFontSize = $labelFontSize;
        return $this;
    }

    /**
     * @param float $padding
     * @return $this
     */
    public function setPadding(float $padding)
    {
        $this->padding = $padding;
        return $this;
    }

    /**
     * @param int $margin
     * @return $this
     */
    public function setMargin($margin)
    {
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

    public function br(): void
    {
        $this->br .= "<br>";
    }

    /**
     * @return string
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     */
    public function render()
    {
        $builder = Builder::create();
        $builder->writer(new PngWriter())
            ->writerOptions([])
            ->data($this->content)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->roundBlockSizeMode(new RoundBlockSizeModeNone())
            ->foregroundColor(new Color(0, 0, 0))
            ->backgroundColor(new Color(255, 255, 255));

        if ($this->margin !== null) {
            $builder->margin($this->margin);
        }

        if (!empty($this->size)) {
            $builder->size($this->size);
        }

        if (!empty($this->label)) {
            $builder->labelText($this->label);
        }

        $result = $builder->build();

        if ($this->br === null) {
            if ($this->align == 'left') {
                $styles[] = "float: left";
            } else {
                $styles[] = "float: right";
            }
        }

        $style = "";
        if (!empty($styles)) {
            $style = "style='" . implode(";", $styles) . "'";
        }

        return "<img " . $style . " src='{$result->getDataUri()}'>" . $this->br;
    }
}
