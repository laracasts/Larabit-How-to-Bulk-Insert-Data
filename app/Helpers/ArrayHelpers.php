<?php

namespace App\Helpers;

class ArrayHelpers {
    public static function chunkFile(string $path, callable $generator, int $chunkSize ) {
        $file = fopen($path, 'r');
        $data = [];

        for ($ii = 1; ($row = fgetcsv($file, null, ',')) !== false; $ii++) {
            $data[] = $generator($row);

            if ($ii % $chunkSize == 0) {
                yield $data;
                $data = [];
            }
        }

        if (!empty($data)) {
            yield $data;
        }

        fclose($file);
    }
}