# SSL certificate automation for scottduncombe.com

Your site is on Namecheap shared hosting (LiteSpeed / cPanel, `dns1/dns2.namecheaphosting.com`).
You should not need to manually refresh Let's Encrypt certs every 90 days. Options, best first:

## Option A — cPanel AutoSSL (recommended, zero infrastructure)

Namecheap's cPanel ships with **AutoSSL**, which issues and *auto-renews* Let's Encrypt certs.

1. Log into cPanel → **SSL/TLS Status**
2. Check `scottduncombe.com`, `www.scottduncombe.com`, `*.scottduncombe.com`
3. Click **Run AutoSSL**
4. Done. cPanel renews automatically ~30 days before expiry.

If a manual cert was previously installed (one you uploaded yourself), AutoSSL may skip the
domain — remove the manual cert first under **SSL/TLS → Manage SSL sites**.

Verify after enabling:

    curl -vI https://scottduncombe.com 2>&1 | grep -E "issuer|expire"

Issuer should be `Let's Encrypt` / `Sectigo (cPanel)` and you never touch it again.

## Option B — acme.sh from anywhere, deployed over cPanel API

If you ever leave Namecheap or want wildcard certs (`*.scottduncombe.com`), HTTP-based
AutoSSL won't cover it. Use DNS-01 with acme.sh + any DNS provider with an API
(Namecheap's own DNS API is heavily restricted — moving DNS to Cloudflare free is the
usual move), then push the cert to cPanel with acme.sh's built-in deploy hook:

    # one-time setup on any always-on box (VPS, Mac mini, etc.)
    curl https://get.acme.sh | sh -s email=you@example.com
    export CF_Token="..."   # Cloudflare API token, Zone.DNS edit
    acme.sh --issue --dns dns_cf -d scottduncombe.com -d '*.scottduncombe.com'

    # auto-upload to cPanel (UAPI token: cPanel -> Manage API Tokens)
    export DEPLOY_CPANEL_USER=scottdun
    export DEPLOY_CPANEL_TOKEN=...
    acme.sh --deploy -d scottduncombe.com --deploy-hook cpanel_uapi

acme.sh installs its own cron job; renewals + deploys are fully hands-off.

## Option C — scheduled from GitHub Actions

Same as B but run from CI instead of your machine. Add repo secrets `CF_TOKEN`,
`CPANEL_USER`, `CPANEL_TOKEN`, then:

```yaml
name: Renew TLS cert
on:
  schedule:
    - cron: "0 6 1 * *"   # monthly; acme.sh renews only when <30 days left
  workflow_dispatch: {}
jobs:
  renew:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Install acme.sh
        run: curl https://get.acme.sh | sh -s email=you@example.com
      - name: Issue/renew (DNS-01 via Cloudflare)
        env:
          CF_Token: ${{ secrets.CF_TOKEN }}
        run: |
          ~/.acme-sh/acme.sh --issue --dns dns_cf --force \
            -d scottduncombe.com -d '*.scottduncombe.com'
      - name: Deploy to cPanel
        env:
          DEPLOY_CPANEL_USER: ${{ secrets.CPANEL_USER }}
          DEPLOY_CPANEL_TOKEN: ${{ secrets.CPANEL_TOKEN }}
        run: |
          ~/.acme-sh/acme.sh --deploy -d scottduncombe.com --deploy-hook cpanel_uapi
```

**Bottom line:** try Option A today — it probably deletes this todo entirely.
Options B/C only matter if you need wildcards or switch hosts.
