<?php
/**
 *
 * @package cloudflare-cli
 * @author Sergei Miami <miami@blackcrystal.net>
 */

namespace App\Cloudflare;

use DiDom\Document;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Documentation
{

    const FILENAME = 'documentation.html';

    private $client, $parser, $storage;

    public function __construct()
    {
        $this->client = Http::baseUrl('https://api.cloudflare.com');
        $this->storage = Storage::disk();
    }

    public function download()
    {
        if (!$this->storage->exists(self::FILENAME))
        {
            $content = $this->client->get('/');
            $this->storage->put(self::FILENAME, $content);
        }
        return $this;
    }

    public function parse()
    {
        if (is_null($this->parser))
        {
            $path = $this->storage->path(self::FILENAME);
            $this->parser = new Document($path,true);
        }
        return $this->parser;
    }



}
