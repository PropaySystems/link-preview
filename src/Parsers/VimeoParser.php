<?php

namespace Propay\LinkPreview\Parsers;

use Propay\LinkPreview\Contracts\LinkInterface;
use Propay\LinkPreview\Contracts\ReaderInterface;
use Propay\LinkPreview\Contracts\ParserInterface;
use Propay\LinkPreview\Contracts\PreviewInterface;
use Propay\LinkPreview\Models\VideoPreview;
use Propay\LinkPreview\Readers\HttpReader;

/**
 * Class YouTubeParser
 */
class VimeoParser extends BaseParser implements ParserInterface
{
    /**
     * Url validation pattern based on http://stackoverflow.com/questions/13286785/get-video-id-from-vimeo-url/22071143#comment48088417_22071143
     */
    const PATTERN = '/^.*(?:vimeo.com)\\/(?:channels\\/|groups\\/[^\\/]*\\/videos\\/|album\\/\\d+\\/video\\/|video\\/|)(\\d+)(?:$|\\/|\\?)/';

    /**
     * @param ReaderInterface $reader
     * @param PreviewInterface $preview
     */
    public function __construct(ReaderInterface $reader = null, PreviewInterface $preview = null)
    {
        $this->setReader($reader ?: new HttpReader());
        $this->setPreview($preview ?: new VideoPreview());
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return 'vimeo';
    }

    /**
     * @inheritdoc
     */
    public function canParseLink(LinkInterface $link): bool
    {
        return (preg_match(static::PATTERN, $link->getUrl()));
    }

    /**
     * @inheritdoc
     */
    public function parseLink(LinkInterface $link): static
    {
        preg_match(static::PATTERN, $link->getUrl(), $matches);

        $this->getPreview()
            ->setId($matches[1])
            ->setEmbed(
                '<iframe id="viplayer" width="640" height="390" src="//player.vimeo.com/video/'.$this->getPreview()->getId().'"" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
            );

        return $this;
    }
}
