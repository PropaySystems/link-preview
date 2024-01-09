<?php

namespace Propay\LinkPreview\Parsers;

use Propay\LinkPreview\Contracts\LinkInterface;
use Propay\LinkPreview\Contracts\ReaderInterface;
use Propay\LinkPreview\Contracts\PreviewInterface;

abstract class BaseParser
{
    /**
     * @var ReaderInterface $reader
     */
    private $reader;

    /**
     * @var PreviewInterface $preview
     */
    private $preview;

    /**
     * @inheritdoc
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @inheritdoc
     */
    public function setPreview(PreviewInterface $preview)
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Read link
     * @param LinkInterface $link
     * @return LinkInterface
     */
    protected function readLink(LinkInterface $link)
    {
        return $this->getReader()->readLink($link);
    }
}