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
class YouTubeParser extends BaseParser implements ParserInterface
{
    /**
     * Url validation pattern taken from http://stackoverflow.com/questions/2964678/jquery-youtube-url-validation-with-regex
     */
    const PATTERN = '/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/';

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
        return 'youtube';
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
                '<iframe id="ytplayer" type="text/html" width="640" height="390" src="//www.youtube.com/embed/'.$this->getPreview()->getId().'" frameborder="0"></iframe>'
            );

        return $this;
    }
}
