<?php namespace Ormic;

use \Illuminate\Support\Str;

class CSV
{

    private $handle;
    private $head_name_map;
    private $head_index_map;
    private $current_line;

    public function __construct($filename)
    {
        $this->handle = fopen($filename, "r");
        if ($this->handle === false) {
            throw new \Exception("Unable to open $filename.");
        }
        // Find indexes of headers
        $header_row = fgetcsv($this->handle);
        $index = 0;
        foreach ($header_row as $header) {
            $slug = Str::slug($header);
            $this->head_name_map[$slug] = $index;
            $this->head_index_map[$index] = $slug;
            $index ++;
        }
    }

    public function get($header, $optional = false)
    {
        $slug = Str::slug($header);
        if (isset($this->head_name_map[$slug])) {
            return trim($this->current_line[$slug]);
        }
        if ($optional) {
            return false;
        } else {
            throw new \Exception("'$header' column not found in: " . print_r($this->head_name_map, true));
        }
    }

    public function next()
    {
        $line = fgetcsv($this->handle);
        $this->current_line = array();
        $index = 0;
        foreach ($this->head_index_map as $index => $header_name) {
            $this->current_line[$header_name] = array_get($line, $index);
        }
        return $line !== false;
    }

    /**
     * Whether or not this CSV has a header named $header.
     *
     * @param string $header The header to look for.
     * @return boolean
     */
    public function hasHeader($header)
    {
        return isset($this->head_name_map[Str::slug($header)]);
    }
}
