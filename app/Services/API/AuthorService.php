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

namespace App\Services\API;

use App\Author;
use App\Exceptions\AuthorException;
use App\Services\ApiService;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class AuthorService
 * @package App\Services\API
 */
class AuthorService extends ApiService
{
    /**
     * @param int $page
     * @return LengthAwarePaginator
     * @throws AuthorException
     */
    public function getPaginateData(int $page = 1): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $authors */
        $authors = Author::paginate(self::PER_PAGE, ['*'], 'page', $page);

        if ($authors->isEmpty()) {
            throw AuthorException::noData();
        }

        return $authors;
    }
}
