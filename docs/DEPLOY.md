# Deploying

The portfolio deploys the same way as the games: every push to `main` that passes the tests is published to a `deploy` branch, and the host keeps a Git clone of that branch as the site's folder, updated by a cron job.

```
push to main ─▶ GitHub Actions: tests, build, assemble ─▶ deploy branch ─▶ cron on the host: git pull + migrations ─▶ live
```

## How it fits together

- **The workflow** is `.github/workflows/deploy.yml`. It runs the PHPUnit suite against MariaDB, builds the Vite assets, installs production packages only, compiles `.env` to `.env.local.php` for prod, and publishes the result to `deploy`. Pull requests run the tests and stop there.
- **The layout.** The primary domain's document root is fixed to `public_html`, so the published site is `public/`'s contents at the root, with the rest of the app beside them (`src/`, `vendor/`, `config/`…). Each of those folders gets a deny-all `.htaccess`, and the root `.htaccess` refuses `.git`, `.env*`, `composer.json` and `BUILD`. PHP still reads them from disk; they just can't be fetched as URLs. This is the same layout the old FTP deploy used.
- **Secrets** never go in the repository (which is public) or the web root. `config/runtime.php` loads `~/portfolio.env`, the folder above `public_html`, for `APP_SECRET`, `DATABASE_URL`, `MAILER_DSN` and `DEFAULT_URI`.
- **The cache.** The workflow writes the commit into `BUILD`, and `Kernel::getCacheDir()` puts each build's cache in its own `var/cache/prod-<build>` folder. A new deploy starts a fresh cache by itself, with no cache clearing on the host. Old folders can be deleted at any time.
- **Migrations** run from the cron job after each pull, so a schema change ships like any other change.
- **Logs** are in `~/public_html/var/log/`, one JSON file a day (`prod-2026-10-15.log`), kept for 14 days.

## Switching over from the FTP deploy (once)

Everything below is in cPanel's **Terminal**. The PHP command is the 8.4 binary the games use; if `php -v` already says 8.4, plain `php` works too.

1. **Wait for the first green run on `main`.** Merging this change and pushing creates the `deploy` branch. Until the host is switched over, the live site carries on as it is.

2. **Check for a cPanel PHP block in the current `.htaccess`:**

   ```sh
   grep -n "cPanel-generated" ~/public_html/.htaccess || echo "none"
   ```

   If it prints `none`, carry on. If it prints a block, see [If cPanel manages the PHP version](#if-cpanel-manages-the-php-version) after step 4.

3. **Move the secrets outside the web root.** The FTP deploy left the real values in `~/public_html/.env.local`:

   ```sh
   grep -E '^(APP_SECRET|DATABASE_URL|MAILER_DSN)=' ~/public_html/.env.local > ~/portfolio.env
   echo 'DEFAULT_URI=https://proprietary-data.com' >> ~/portfolio.env
   chmod 600 ~/portfolio.env
   cat ~/portfolio.env
   ```

   Check it shows four lines with nothing stray at the ends. A malformed `MAILER_DSN` once took down `/contact` on its own.

4. **Swap `public_html` for a clone of the `deploy` branch.** The repository is public, so no key is needed:

   ```sh
   cd ~
   git clone -q --branch deploy --single-branch https://github.com/FeatheredFiend/portfolio.git portfolio-deploy
   [ -d public_html/.well-known ] && cp -a public_html/.well-known portfolio-deploy/
   mv public_html public_html.ftp-old && mv portfolio-deploy public_html
   ```

   The swap is two renames, so the site is down for a moment at most. To undo it: `mv public_html portfolio-deploy && mv public_html.ftp-old public_html`.

5. **Check the database knows its migrations.** The schema was created from pasted SQL, so confirm the version was recorded:

   ```sh
   cd ~/public_html && /opt/cpanel/ea-php84/root/usr/bin/php bin/console doctrine:migrations:status
   ```

   Expect **Executed 1** and **New 0**. If it says New 1 instead, mark the existing schema as migrated, once:

   ```sh
   /opt/cpanel/ea-php84/root/usr/bin/php bin/console doctrine:migrations:version --add --all -n
   ```

6. **Add the cron job.** Under **Cron Jobs**, every five minutes:

   ```sh
   cd ~/public_html && git pull -q --ff-only origin deploy && /opt/cpanel/ea-php84/root/usr/bin/php bin/console doctrine:migrations:migrate -n -q --allow-no-migration
   ```

7. **Check it.**
   - https://proprietary-data.com/projects shows the Games section.
   - These all answer 403 or 404: `/.git/config`, `/.env.local.php`, `/BUILD`, `/vendor/autoload.php`, `/src/Kernel.php`.
   - `curl -sI https://proprietary-data.com | grep -i x-powered-by` still says PHP 8.4.

8. **Tidy up**, once you're happy:
   - `rm -rf ~/public_html.ftp-old`
   - In the repo's **Settings → Secrets and variables → Actions**, delete `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`, `PROD_APP_SECRET`, `PROD_DATABASE_URL` and `PROD_MAILER_DSN`. Nothing reads them any more.
   - The *Generate migration SQL* and *Create admin* workflows are optional now: from Terminal, `bin/console doctrine:migrations:migrate` and `bin/console app:create-admin-user` run directly.

From then on, every push to `main` is live within about five minutes of its run going green.

## If something goes wrong

- **Old version still showing:** run `git -C ~/public_html log -1 --oneline` and compare it with the latest commit on the `deploy` branch on GitHub. If they differ, run the cron command by hand to see its error. If they match, check that `~/public_html/BUILD` changed.
- **A 500 error:** read the end of the newest file in `~/public_html/var/log/`. The usual causes are a wrong line in `~/portfolio.env`, or PHP older than 8.4.
- **The pull says local changes would be overwritten:** something on the host edited a tracked file, most likely cPanel writing into `.htaccess`. `git -C ~/public_html status` names the file. See the next section.

### If cPanel manages the PHP version

cPanel's MultiPHP Manager sets a domain's PHP version by writing a block into its `.htaccess`. Here that file comes from Git, so after the swap, the block from the old folder is gone.

- If PHP still reports 8.4 after the swap (step 7), nothing is needed.
- If it doesn't, set **proprietary-data.com** to **PHP 8.4** in **MultiPHP Manager** again, which writes the block into the new `.htaccess`. Then tell Git to leave that edit alone: `git -C ~/public_html update-index --skip-worktree .htaccess`. Pulls then carry on as normal. If a later deploy changes `.htaccess` itself, the pull stops with a message rather than breaking the site; `git -C ~/public_html update-index --no-skip-worktree .htaccess`, `git -C ~/public_html checkout .htaccess`, pull, then set the PHP version again.
