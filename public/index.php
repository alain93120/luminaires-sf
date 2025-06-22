<?php declare(strict_types=1);

// Turn off PHP’s own error display:
ini_set('display_errors', '0');

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Les use doivent être à l’intérieur du même bloc PHP,
// et après votre déclaration error_reporting()
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
