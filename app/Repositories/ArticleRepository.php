<?php
/**
 * @copyright C VR Solutions 2018
 *
 * This software is the property of VR Solutions
 * and is protected by copyright law – it is NOT freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact VR Solutions:
 * E-mail: vytautas.rimeikis@gmail.com
 * http://www.vrwebdeveloper.lt
 */

declare(strict_types = 1);

namespace App\Repositories;

use App\Article;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
class ArticleRepository extends Repository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return Article::class;
    }

    /**
     * Return first row from DB or null if not found
     *
     * @param string $slug
     * @return Builder|\Illuminate\Database\Eloquent\Model|null|object
     * @throws \Exception
     */
    public function getBySlug(string $slug)
    {
        return $this->getBySlugBuilder($slug)->first();
    }

    /**
     * @param string $slug
     * @param int $id
     * @return Builder|\Illuminate\Database\Eloquent\Model|null|object
     * @throws \Exception
     */
    public function getBySlugAndNotId(string $slug, int $id)
    {
        return $this->getBySlugBuilder($slug)
            ->where('id', '!=', $id)
            ->first();
    }

    /**
     * @param string $slug
     * @return Builder
     * @throws \Exception
     */
    private function getBySlugBuilder(string $slug): Builder
    {
        return $this->makeQuery()
            ->where('slug', $slug);
    }
}