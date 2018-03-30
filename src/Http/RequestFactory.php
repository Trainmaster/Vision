<?php
declare(strict_types = 1);

namespace Vision\Http;

class RequestFactory
{
    /**
     * @return Request
     */
    public function make(): Request
    {
        return new Request(
            new Url(),
            $_GET,
            $_POST,
            $_SERVER,
            $_COOKIE,
            $this->transformFilesArray($_FILES)
        );
    }

    /**
     * @param array $files
     * @return array
     */
    private function transformFilesArray(array $files): array
    {
        foreach ($files as &$value) {
            $newArray = [];

            foreach ($value as $key => $val) {
                if (is_array($val)) {
                    array_walk_recursive($val, function (&$item) use ($key) {
                        $item = [$key => $item];
                    });
                    $newArray = array_replace_recursive($newArray, $val);
                }
            }

            if (!empty($newArray)) {
                $value = $newArray;
            }
        }

        return $files;
    }
}
