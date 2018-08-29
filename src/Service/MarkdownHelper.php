<?php

namespace App\Service;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;

class MarkdownHelper
{
    public function __construct(
        AdapterInterface $cache,
        MarkdownInterface $markdown,
        LoggerInterface $markdownLogger
    )
    {
        $this->cache = $cache;
        $this->markdown = $markdown;
        $this->logger = $markdownLogger;
    }

    public function parse(string $source): string {
        if (stripos($source, 'bacon')){
            $this->logger->info('They are talking about bacon again!');
        }

        $item = $this->cache->getItem('markdown_'.md5($source));
        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}