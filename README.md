# Medienreaktor.Hcaptcha

[hCaptcha](https://www.hcaptcha.com/) field for [Sitegeist.PaperTiger](https://github.com/sitegeist/Sitegeist.PaperTiger) forms in Neos 9.

The package ships:

- a `Medienreaktor.Hcaptcha:Hcaptcha` PaperTiger field NodeType (group `form.special`)
- the matching Fusion component that renders the widget and a hidden input for the captcha response
- a server-side `HcaptchaValidator` that verifies the token against `https://api.hcaptcha.com/siteverify`

## Installation

The package lives in `DistributionPackages/` and is wired into the root `composer.json`:

```json
"require": {
    "medienreaktor/hcaptcha": "*"
}
```

After `composer update` and `./flow flow:cache:flush` the field shows up in the PaperTiger field picker.

## Configuration

Add your hCaptcha keys to any `Settings*.yaml` (e.g. `Configuration/Settings.Hcaptcha.yaml`):

```yaml
Medienreaktor:
  Hcaptcha:
    siteKey: 'your-public-site-key'
    secretKey: 'your-secret-key'
```

Get the keys from your [hCaptcha dashboard](https://dashboard.hcaptcha.com/).

## Usage

Drop the `Medienreaktor.Hcaptcha:Hcaptcha` field into any PaperTiger form via the Neos UI. No further Fusion wiring is needed — the package's Fusion is auto-included via `Neos.Neos.fusion.autoInclude`.

## How it works

- The frontend renders the official hCaptcha widget (`https://js.hcaptcha.com/1/api.js`) plus a hidden input (`class="verify-captcha"`).
- On successful challenge, the global `setHcaptchaResponse(token)` callback (loaded from `Resources/Public/JavaScript/Hcaptcha.js`) writes the token into the hidden input.
- On submit, `Medienreaktor\Hcaptcha\Validation\Validator\HcaptchaValidator` POSTs `secret` + `response` to hCaptcha's `siteverify` endpoint and rejects the form if the response is not `success: true`.

## License

GPL-3.0-or-later