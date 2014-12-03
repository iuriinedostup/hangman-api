<?php

namespace Src\Library;

class ApplicationConst
{
    const APP_CONFIG_FILE = 'application.ini';
    const APP_CONFIG_DIR = 'Config';

    const REQUEST_METHOD_GET = 'GET';
    const REQUEST_METHOD_POST = 'POST';
    const REQUEST_METHOD_PUT = 'PUT';
    const REQUEST_METHOD_DELETE = 'DELETE';

    const NS_API_OBJECT = 'Src\Application\APIObjects\\';
    const NS_RESPONSE_PROVIDER = 'Src\Library\Core\Response\Provider\\';
    const NS_DB_CLASSES = 'Src\Library\Core\Classes\Db\\';

}