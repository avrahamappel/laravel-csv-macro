<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

Collection::macro('csv',
    /**
     * A path in your application's "storage" directory
     *
     * @param  string $path
     * @return string The full path
     */
    function ($path) {

    /**
     * @var \Illuminate\Support\Collection $this
     */
    $this->prepend(
        array_map(function ($key) {
            return ucwords(str_replace(['-', '_'], ' ', $key));
        }, array_keys($this->items[0]))
    );

    $fullpath = Storage::path($path);
    $handle   = fopen($fullpath, 'w');

    $this->each(function ($line) use ($handle) {
        fputcsv($handle, $line);
    });

    fclose($handle);

    return $fullpath;
});
