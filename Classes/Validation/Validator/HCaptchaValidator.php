<?php
declare(strict_types=1);

namespace Medienreaktor\PaperTiger\HCaptcha\Validation\Validator;

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Uri;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Http\Client\CurlEngine;
use Neos\Flow\Validation\Validator\AbstractValidator;

class HCaptchaValidator extends AbstractValidator {
    /**
     * @Flow\InjectConfiguration(path="secretKey")
     * @var string
     */
    protected $secretKey;

    protected function isValid($value): void {
        if (!$value) {
            $this->addError('Der Request konnte nicht gelesen werden.', 1649869170);
            return;
        }

        $client = new CurlEngine();
        $client->setOption(CURLOPT_RETURNTRANSFER, true);
        $response = $client->sendRequest(
            new ServerRequest(
                'POST',
                new Uri('https://api.hcaptcha.com/siteverify'),
                ['Content-Type' => 'application/x-www-form-urlencoded'],
                http_build_query([
                    'secret' => $this->secretKey,
                    'response' => $value,
                ])
            )
        );

        $body = json_decode($response->getBody()->getContents() ?: '');
        if (!is_object($body) || empty($body->success)) {
            $this->addError('Captcha is invalid.', 20230123115302);
        }
    }
}