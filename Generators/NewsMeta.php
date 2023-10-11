<?php

namespace App\Services\Meta\Generators;

use App\Models\DBSQL\News;
use App\Models\DBSQL\SeoParameter as SeoModel;
use App\Services\Meta\Facades\Meta;
use Illuminate\Http\Request;
use App\Helpers\RequestHelper;

class NewsMeta
{
    /**
     * @var SeoModel|null
     */
    private ?SeoModel $seoData;

    /**
     * NewsMeta constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $uri = RequestHelper::getUri($request);
        $this->seoData = SeoModel::where('uri', $uri)->first();
    }

    /**
     * Set meta tags for the main page
     */
    public function index(): void
    {
        $defaultValues = [
            'title' => trans('seo.news.title'),
            'description' => trans('seo.news.description'),
            'keywords' => trans('seo.news.keywords'),
            'h1' => trans('seo.news.h1'),
            'header_text_title' => trans('seo.news.header_text_title'),
            'header_text' => trans('seo.news.header_text'),
            'footer_text_title' => trans('seo.news.footer_text_title'),
            'footer_text' => trans('seo.news.footer_text'),
        ];

        $this->setMetaTags($defaultValues);
    }

    /**
     * Set meta tags for the detail page
     *
     * @param News $news
     */
    public function detail(News $news): void
    {
        $description = mb_substr($news->description, 0, 155);
        $defaultValues = [
            'title' => $news->title,
            'description' => $description,
            'h1' => $news->title,
        ];

        $this->setMetaTags($defaultValues);
    }

    /**
     * Set meta tags
     *
     * @param array $defaultValues
     */
    private function setMetaTags(array $defaultValues): void
    {
        $fields = [
            'title',
            'description',
            'keywords',
            'h1',
            'header_text_title',
            'header_text',
            'footer_text_title',
            'footer_text',
        ];

        foreach ($fields as $field) {
            if ($this->seoData && !empty($this->seoData->$field)) {
                $value = $this->seoData->$field;
            } else {
                $value = $defaultValues[$field] ?? null;
            }
            Meta::set($field, $value);
        }
    }
}
