<?php
declare(strict_types = 1);

namespace TechDivision\Card\Eel;

use TechDivision\Card\Exceptions\WrongUriException;
use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Http\Client\Browser;
use Neos\Flow\Http\Client\CurlEngine;
use Symfony\Component\DomCrawler\Crawler;


/*
* This file is part of the TechDivision.Card package.
*
* TechDivision - neos@techdivision.com
*
* This package is Open Source Software. For the full copyright and license
* information, please view the LICENSE file which was distributed with this
* source code.
*/

class SocialCardHelper implements ProtectedContextAwareInterface
{

    /**
     * @Flow\Inject
     * @var Browser
     */
    protected $browser;

    /**
     * @return void
     */
    public function initializeObject()
    {
        $requestEngine = new CurlEngine();
        $requestEngine->setOption(CURLOPT_TIMEOUT, '300');
        $this->browser->setRequestEngine($requestEngine);
    }

    /**
     * Return a Symfony Crawler object that we can work with
     *
     * @param string $externalUri
     * @throws WrongUriException
     * @return Crawler
     */
    public function getCrawler(string $externalUri = null): ?Crawler
    {
        if (!$externalUri) {
            return null;
        }

        if (filter_var($externalUri, FILTER_VALIDATE_URL) === false) {
            throw new WrongUriException($externalUri . ' is not a valid URI');
        }

        $this->browser->request($externalUri);
        return $this->browser->getCrawler();
    }

    /**
     * Returns an open graph property
     * Sets og: prefix
     *
     * @param Crawler|null $crawler
     * @param string $openGraphProperty
     * @return string
     */
    public function getOpenGraphProperty(?Crawler $crawler, string $openGraphProperty): string
    {
        if ($crawler === null) {
            return '';
        }
        return $this->getMetaTagByPropertyOrName($crawler, 'og:' . strtolower($openGraphProperty));
    }

    /**
     * Returns an open graph property
     * Sets twitter: prefix
     *
     * @param Crawler|null $crawler
     * @param string $twitterCardProperty
     * @return string
     */
    public function getTwitterCardProperty(?Crawler $crawler, string $twitterCardProperty): string
    {
        if ($crawler === null) {
            return '';
        }

        return $this->getMetaTagByPropertyOrName($crawler, 'twitter:' . strtolower($twitterCardProperty));
    }

    /**
     * Returns <title>
     *
     * @param Crawler|null $crawler
     * @return string
     */
    public function getTitle(?Crawler $crawler): string
    {
        if ($crawler === null) {
            return '';
        }

        $titleTags = $crawler->filter("title");
        foreach ($titleTags as $titleTag) {
            return $titleTag->textContent;
        }
        return '';
    }

    /**
     * Gets a certain meta property by checking
     * <meta name> or <meta property>
     *
     * @param $crawler
     * @param $property
     * @return mixed
     */
    protected function getMetaTagByPropertyOrName($crawler, $property): string
    {
        $metaTags = $crawler->filter("meta[property^='" . $property . "'], meta[name^='" . $property . "']");
        foreach ($metaTags as $metaTag) {
            // take first occurence whatsoever
            return $metaTag->getAttribute('content');
        }
        return '';
    }

    /**
     * @param string $methodName
     *
     * @return boolean
     */
    public function allowsCallOfMethod($methodName): bool
    {
        return true;
    }

}
