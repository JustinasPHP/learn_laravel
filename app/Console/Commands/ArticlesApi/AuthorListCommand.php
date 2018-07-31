<?php

declare(strict_types = 1);

namespace App\Console\Commands\ArticlesApi;

use App\Author;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

/**
 * Class AuthorListCommand
 * @package App\Console\Commands\ArticlesApi
 */
class AuthorListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:authors-list';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get authors list';
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $url;
    /**
     * @var \Illuminate\Config\Repository|mixed
     */
    private $version;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->url = config('article_api.api_url');
        $this->version = config('article_api.api_version');
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(): void
    {
        $client = new Client();

        $result = $client->request('GET', $this->getCallUrl());

        $data = json_decode($result->getBody()->getContents());

        if (!$data->success) {
            logger($data->message, $data);

            exit();
        }

        foreach ($data->data as $row) {
            $author = $this->saveData($row);
            $this->info('Updated or created author with refernce: ' . $author->reference_author_id);
        }
    }

    /**
     * @param \stdClass $data
     * @return Author
     */
    private function saveData(\stdClass $data): Author
    {
        return Author::updateOrCreate(
            ['first_name' => $data->first_name, 'last_name' => $data->last_name],
            ['reference_author_id' => $data->author_id]
        );
    }

    /**
     * @return string
     */
    private function getCallUrl(): string
    {
        return sprintf('%s/%s/author', $this->url, $this->version);
    }
}