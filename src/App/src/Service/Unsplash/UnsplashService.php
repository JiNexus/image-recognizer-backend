<?php

declare(strict_types=1);

namespace App\Service\Unsplash;

use Unsplash;

class UnsplashService
{
    /**
     * @param array $config
     */
    public function __construct(
        private readonly array $config
    )
    {
        $this->initClient();
    }

    /**
     * @return void
     */
    public function initClient(): void
    {
        // Note: if you're just using actions that require the public permission scope, only the access key is required.
        // Access key is entered as applicationId due to legacy reasons.
        //
        // Note: if utmSource is omitted from $credentials a notice will be raised.

        Unsplash\HttpClient::init([
            'applicationId'	=> $this->config['access_key'],
            'secret'	=> $this->config['secret_key'],
            'utmSource' => 'Recursive' // Name of the Unsplash Application
        ]);
    }

    /**
     * @param string $search
     * @param int $page
     * @param int $perPage
     * @param string|null $orientation
     * @param string|null $collections
     * @param string $orderBy
     * @return Unsplash\PageResult
     */
    public function searchPhotos(
        string $search, // Required
        int $page = 1, // Opt (Default: 1)
        int $perPage = 10, // Opt (Default: 10 / Maximum: 30)
        string $orientation = null, // Opt (Default: null / Available: "landscape", "portrait", "squarish")
        string $collections = null, // Opt (Default: null / If multiple, comma-separated)
        string $orderBy = 'relevant' // How to sort the photos. (Optional; default: relevant). Valid values are latest and relevant.
    ): Unsplash\PageResult
    {
        return Unsplash\Search::photos(
            $search,
            $page,
            $perPage,
            $orientation,
            $collections,
            $orderBy
        );
    }

    /**
     * @param $id
     * @return string
     */
    public function download($id): string
    {
        $photo = Unsplash\Photo::find($id);
        return $photo->download();
    }

    /**
     * @param $url
     * @return string
     */
    public function getFilename($url): string
    {
        // Get the basename from the URL
        $basename = basename(parse_url($url, PHP_URL_PATH));

        // Extract the file extension from the basename
        $file_extension = pathinfo($basename, PATHINFO_EXTENSION);

        if (! $file_extension) {
            // Parse the URL to get the query string
            $query_string = parse_url($url, PHP_URL_QUERY);

            // Parse the query string to get individual parameters
            parse_str($query_string, $parameters);

            $file_extension = $parameters['fm'];
        }

        return $basename . '.' . $file_extension;
    }
}
