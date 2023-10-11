<?php

namespace App\Services\Meta;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class MetaService
{

    /**
     * Instance of request
     *
     * @var Request
     */
    private Request $request;

    /**
     * @var array
     */
    private array $metas = [];


    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        // Set defaults
        $this->set('url', $this->request->url());
    }

    /**
     * @param string $key
     * @param string|null $default
     *
     * @return string
     */
    public function get(string $key, string $default = null): string
    {
        return Arr::get($this->metas, $key, $default);
    }

    /**
     * @param string $key
     * @param string|null $value
     *
     * @return string
     */
    public function set(string $key, string $value = null): ?string
    {
        //$value = $this->fix($value);

        $method = 'set' . $key;

        if (method_exists($this, $method)) {
            return $this->$method($value);
        }

        return $this->metas[$key] = $value;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function fix(string $text): string
    {
        $text = preg_replace('/<[^>]+>/', ' ', $text);
        $text = preg_replace('/[\r\n\s]+/', ' ', $text);

        return trim(str_replace('"', '&quot;', $text));
    }

}
