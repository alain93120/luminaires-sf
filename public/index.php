<?php declare(strict_types=1);

// Si E_STRICT n'existe pas (PHP 8.1+), on la définit à 0
if (!\defined('E_STRICT')) {
    \define('E_STRICT', 0);
}

// Désactive l’affichage direct des erreurs
ini_set('display_errors', '0');

// Déterminez vous-mêmes le niveau d’erreurs souhaité :
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_NOTICE);

// Le reste de votre bootstrap…
use App\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    if ($context['APP_DEBUG']) {
        Debug::enable();
    }

    Request::enableHttpMethodParameterOverride();

    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
