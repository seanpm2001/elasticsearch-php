<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1
 *
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */


declare(strict_types = 1);

namespace Elasticsearch\Tests;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class Utility
{
    public static function getHost(): ?string
    {
        $url = getenv('ELASTICSEARCH_URL');
        if (false !== $url) {
            return $url;
        }
        switch (getenv('TEST_SUITE')) {
            case 'oss':
                return 'http://localhost:9200';
            case 'xpack':
                return 'https://elastic:changeme@localhost:9200';
        }
        return null;
    }

    public static function getClient(): Client
    {
        $clientBuilder = ClientBuilder::create()
            ->setHosts([self::getHost()]);
        if (getenv('TEST_SUITE') === 'xpack') {
            $clientBuilder->setSSLVerification(false);
        }
        return $clientBuilder->build();
    }
}