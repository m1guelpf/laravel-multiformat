# Multiformat Endpoints in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/m1guelpf/laravel-multiformat.svg?style=flat-square)](https://packagist.org/packages/m1guelpf/laravel-multiformat)
[![Total Downloads](https://img.shields.io/packagist/dt/m1guelpf/laravel-multiformat.svg?style=flat-square)](https://packagist.org/packages/m1guelpf/laravel-multiformat)

## Installation

You can install the package via composer:

```bash
composer require m1guelpf/laravel-multiformat
```

## Usage

``` php
<?php
/**
 * Mark a route as 'multiformat' to allow different extensions (html, json, xml, etc.)
 *
 * This route will match all of these requests:
 *     /podcasts/4
 *     /podcasts/4.json
 *     /podcasts/4.html
 *     /podcasts/4.zip
 */
Route::get('/podcasts/{id}', 'PodcastsController@show')->multiformat();
/**
 * Use `Request::match()` to return the right response for the requested format.
 *
 * Supports closures to avoid doing unnecessary work, and returns 404 if the
 * requested format is not supported.
 *
 * Will also take into account the `Accept` header if no extension is provided.
 */
class PodcastsController
{
    public function show($id)
    {
        $podcast = Podcast::findOrFail($id);
        return request()->match([
            'html' => view('podcasts.show', [
                'podcast' => $podcast,
                'episodes' => $podcast->recentEpisodes(5),
            ]),
            'json' => $podcast,
            'xml' => function () use ($podcast) {
                return response($podcast->toXml(), 200, ['Content-Type' => 'text/xml']);
            }
        ]);
    }
}
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email soy@miguelpiedrafita.com instead of using the issue tracker.

## Credits

- [Adam Wathan](https://github.com/adamwathan) for the [original gist](https://gist.github.com/adamwathan/984914b2eee8e4d79a06f7045e4ce999)
- [Miguel Piedrafita](https://github.com/m1guelpf)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
