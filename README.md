# Medienreaktor.PaperTiger.HCaptcha

[hCaptcha](https://www.hcaptcha.com/) field for [Sitegeist.PaperTiger](https://github.com/sitegeist/Sitegeist.PaperTiger) forms in Neos 9.

The package ships:

- a `Medienreaktor.PaperTiger.HCaptcha:HCaptcha` PaperTiger field NodeType (group `form.special`)
- the matching Fusion component that renders the widget and a hidden input for the captcha response
- a server-side `HCaptchaValidator` that verifies the token against `https://api.hcaptcha.com/siteverify`

## Installation

```bash
composer require medienreaktor/papertiger-hcaptcha
```

Then run `./flow flow:cache:flush` so Neos picks up the new NodeType, Fusion and Settings.

## Configuration

Add your hCaptcha keys to any `Settings*.yaml` of your site (e.g. `Configuration/Settings.HCaptcha.yaml`):

```yaml
Medienreaktor:
  PaperTiger:
    HCaptcha:
      siteKey: 'your-public-site-key'
      secretKey: 'your-secret-key'
```

Get the keys from your [hCaptcha dashboard](https://dashboard.hcaptcha.com/).

## Usage

Drop the `Medienreaktor.PaperTiger.HCaptcha:HCaptcha` field into any PaperTiger form via the Neos UI. No further Fusion wiring is needed — the package's Fusion is auto-included via `Neos.Neos.fusion.autoInclude`.

## How it works

- The frontend renders the official hCaptcha widget (`https://js.hcaptcha.com/1/api.js`) plus a hidden input (`class="verify-captcha"`).
- On successful challenge, the global `setHcaptchaResponse(token)` callback (loaded from `Resources/Public/JavaScript/HCaptcha.js`) writes the token into the hidden input.
- On submit, `Medienreaktor\PaperTiger\HCaptcha\Validation\Validator\HCaptchaValidator` POSTs `secret` + `response` to hCaptcha's `siteverify` endpoint and rejects the form if the response is not `success: true`.

## License

GPL-3.0-or-later