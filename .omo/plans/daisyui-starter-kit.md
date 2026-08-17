# daisyui-starter-kit - Work Plan

## TL;DR (For humans)
Mevcut `fresh` projesini `yellow-three/daisyui-starter-kit` adında bağımsız bir Laravel Starter Kit'e dönüştürüyoruz. Tüm UI kodu (daisyUI 5 + Livewire 4 + Fortify auth) zaten hazır — iş temizleme, paketleme ve publish. Packagist'e publish edildiğinde `laravel new my-app --using=yellow-three/daisyui-starter-kit` ile tam donanımlı bir uygulama kurulacak. Fortify + 2FA + Passkey + Email Verify, dark/light tema toggle, sidebar layout, settings sayfaları, Pest tests dahil.

## Scope
### IN
- Yeni GitHub repo oluşturma ve mevcut kodu temizleme
- composer.json refactor (type: project, name, scripts, deps)
- package.json cleanup
- .gitattributes ekleme
- README.md yazma
- .env.example temizleme
- Project-specific dosya temizliği (.lerd.yaml, boost.json, .mcp.json, tool dizinleri vb.)
- post-create-project-cmd kurulumu
- Chisel feature selection entegrasyonu
- Tüm mevcut view'lar, component'lar, tests'ler — aynen korunur
- Packagist publish hazırlığı

### OUT (Must-NOT-Have)
- Yeni UI component yazma — mevcut olanları koruyacağız
- Auth flow değişikliği — mevcut Fortify setup korunur
- Yeni sayfa/feature ekleme — sadece temizleme ve paketleme
- Lerd-specific konfigürasyonlar starter kit'te yer almaz
- laravel/boost dependency starter kit'te yer almaz

## Verification strategy
- TDD: Mevcut Pest testleri korunur, yeni test yazılmaz (mevcut coverage yeterli)
- Agent-executed QA: Playwright ile auth flow ve tema toggle doğrulanır
- Final verification: composer create-project ile temiz kurulum test edilir

## Execution strategy
Sequential waves — her wave bir bağımsız birim temizler/paketler, bir sonraki wave'e bağımlı.

## Todos

### Wave 1: Repo & Packaging Foundation

- [ ] 1. `gh repo create yellow-three/daisyui-starter-kit --private` ile yeni GitHub repo oluştur, mevcut `feat/daisyui-migration` branch'inden temiz bir `main` branch'e tüm dosyaları taşı — mevcut branch korunur, yeni repo bağımsız çalışır
  - **References**: `laravel/livewire-starter-kit` repo yapısı (github.com/laravel/livewire-starter-kit), Laravel installer `--using` mekanizması (installer/src/NewCommand.php#L1476-1495)
  - **Acceptance criteria**: `git clone` ile yeni repo clone edilebilir, `composer validate` geçer, dizin yapısı clean (tool-specific dizinler yok)
  - **Happy path QA**: `git remote -v` yeni repo'yu gösterir, `ls -la` tool-specific dizinleri (.lerd.yaml, boost.json, .mcp.json, .omo/, .agents/, .codegraph/, .cursor/, .gemini/, .claude/, .junie/) göstermez
  - **Failure QA**: Eski repo hala mevcut ve çalışır durumda (bağımsız copy)
  - **Commit**: `chore: initialize daisyui-starter-kit repo`

### Wave 2: composer.json Refactor

- [x] 2. `composer.json`'ı starter kit'e dönüştür — `name` → `yellow-three/daisyui-starter-kit`, `description` → daisyUI starter kit açıklaması, `keywords` → `["laravel", "daisyui", "livewire", "starter-kit"]`, `require`'dan `laravel/boost`'u çıkar (devDependency olarak da değil), `require`'a `laravel/chisel` ekle (zaten varsa koru), `require`'dan `livewire/flux`'u çıkar (zaten yok), `require-dev`'den `laravel/boost`'u çıkar, `post-create-project-cmd`'ye `rename_livewire_files.php` ekle (eğer Chisel kullanıyorsa), `extra.laravel.installer.post-create-project`'e `@php artisan install:features --ansi` ekle, `scripts.post-create-project-cmd`'yi güncelle (key:generate, sqlite touch, migrate), `.gitattributes`'e `export-ignore` kuralları ekle
  - **References**: `laravel/livewire-starter-kit/composer.json` (github.com/laravel/livewire-starter-kit/blob/main/composer.json), Laravel installer `runInstallerHooks` (installer/src/NewCommand.php#L1379-1415), Packagist `type: project` requirement
  - **Acceptance criteria**: `composer validate --strict` geçer, `name` field'i `yellow-three/daisyui-starter-kit`, `type` field'i `project`, `require`'da `laravel/boost` yok, `require-dev`'de `laravel/boost` yok, `extra.laravel.installer.post-create-project` mevcut
  - **Happy path QA**: `composer validate --strict --no-check-all` pass, `cat composer.json | jq '.name'` → `"yellow-three/daisyui-starter-kit"`, `cat composer.json | jq '.type'` → `"project"`, `cat composer.json | jq '.require | keys'` → `laravel/boost` içermiyor
  - **Failure QA**: Eski `laravel/livewire-starter-kit` ismi kalmamış, lerd-specific script'ler temizlenmiş
  - **Commit**: `refactor(composer): convert to daisyui starter kit package`

### Wave 3: Package & Config Cleanup

- [x] 3. `package.json`'ı temizle — `daisyui`'ı `devDependencies`'den `dependencies`'e taşı (starter kit'te daisyUI primary dependency), `@laravel/passkeys`'i koru, `concurrently`'i çıkar (lerd-specific), gereksiz `optionalDependencies`'ı temizle
  - **References**: Mevcut `package.json` (resources/js/passkeys.js passkey desteği için `@laravel/passkeys` gerekli), daisyUI 5 kurulumu (daisyui.com/docs/install)
  - **Acceptance criteria**: `npm ls daisyui` version gösterir, `concurrently` yok, `optionalDependencies` temiz
  - **Happy path QA**: `cat package.json | jq '.dependencies'` → `daisyui` mevcut, `cat package.json | jq '.devDependencies'` → `daisyui` yok
  - **Failure QA**: `@laravel/passkeys` hala mevcut (passkey support için gerekli)
  - **Commit**: `refactor(package): clean up npm dependencies for starter kit`

- [x] 4. Project-specific dosyaları starter kit'ten çıkar — `.lerd.yaml`, `.env` (sadece `.env.example` kalır), `.mcp.json`, `boost.json`, `.omo/`, `.agents/`, `.codegraph/`, `.cursor/`, `.gemini/`, `.claude/`, `.junie/`, `opencode_ses.md`, `skills-lock.json`, `.node-version` (lerd-specific), `.php-version` (lerd-specific), `AGENTS.md` (tool-specific), `GEMINI.md` (tool-specific), `phpstan.neon`'daki lerd-specific path'leri temizle (eğer varsa), `.gitignore`'dan lerd-specific entry'leri temizle (e.g. `/.agents`, `/.omo`)
  - **References**: Mevcut `.gitignore`, `.lerd.yaml`, `.mcp.json`, `boost.json` dosya içerikleri
  - **Acceptance criteria**: `ls -la` tool-specific dosyaları göstermez, `.env.example` mevcut, `.env` yok (git'te), `.gitignore` temiz
  - **Happy path QA**: `cat .gitignore | grep -c lerd` → 0, `ls .lerd.yaml 2>&1` → "No such file", `ls .env 2>&1` → "No such file" (git'te yok, .env.example var)
  - **Failure QA**: `.env.example` hala mevcut ve doğru env vars içeriyor
  - **Commit**: `chore: remove project-specific files from starter kit`

- [x] 5. `.gitattributes` oluştur — Packagist dist archive'dan dev-only dosyaları exclude et: `/.github export-ignore`, `/tests export-ignore`, `/phpstan.neon export-ignore`, `/phpunit.xml export-ignore`, `/pint.json export-ignore`, `/.editorconfig export-ignore`, `/README.md export-ignore`, `/CHANGELOG.md export-ignore` (eğer varsa), `/.gitattributes export-ignore` (kendisi hariç — bu mümkün değil, .gitattributes her zaman dahil edilir. Aslında .gitattributes'i export-ignore yapmıyoruz çünkü Packagist onu okuyor. Sadece diğer dev dosyaları exclude ediyoruz.)
  - **References**: `laravel/livewire-starter-kit/.gitattributes` (github.com/laravel/livewire-starter-kit/blob/main/.gitattributes), Packagist export-ignore docs (getcomposer.org/doc/04-schema.md#export-ignore)
  - **Acceptance criteria**: `.gitattributes` dosyası mevcut, tüm dev-only dizinler `export-ignore` ile işaretli, `composer package --list` doğru dosyaları gösterir
  - **Happy path QA**: `cat .gitattributes | grep export-ignore | wc -l` → en az 5 satır, `composer package --list` → tests/, phpstan.neon, phpunit.xml, pint.json listede değil
  - **Failure QA**: `.gitattributes` kendini export-ignore yapmamış (Packagist onu okumalı)
  - **Commit**: `chore: add .gitattributes for Packagist dist`

### Wave 4: Documentation & Env

- [x] 6. `README.md` yaz — Starter kit'i tanıt: başlık ("Laravel + Livewire + daisyUI Starter Kit"), kurulum (`laravel new my-app --using=yellow-three/daisyui-starter-kit`), özellikler (Fortify, 2FA, Passkey, daisyUI 5 dark/light, Livewire 4, Pest), personalizasyon (tema değiştirme, renk ekleme), Tech stack (Laravel 13, Livewire 4, daisyUI 5, Tailwind v4, Fortify, Chisel, Pest 5)
  - **References**: `laravel/livewire-starter-kit/README.md` formatı, Laravel docs starter kit page (laravel.com/docs/starter-kits)
  - **Acceptance criteria**: README.md mevcut, `laravel new --using` komutu doğru, tüm özellikler listeli, tech stack doğru
  - **Happy path QA**: `cat README.md | grep "yellow-three/daisyui-starter-kit"` → match, `cat README.md | grep "daisyUI"` → match
  - **Failure QA**: README'de lerd-specific bilgi yok
  - **Commit**: `docs: add starter kit README`

- [x] 7. `.env.example`'ı temizle ve standalone hale getir — `DB_CONNECTION=sqlite` (default), `SESSION_DRIVER=database`, `QUEUE_CONNECTION=database`, `CACHE_STORE=database` (starter kit defaults), lerd-specific değerleri çıkar (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD yorum satırında kalsın), `APP_URL=http://localhost` (default), `MAIL_MAILER=log` (default)
  - **References**: Mevcut `.env.example`, Laravel skeleton `.env.example` (github.com/laravel/laravel/blob/master/.env.example)
  - **Acceptance criteria**: `.env.example` mevcut, lerd-specific değerler yok, default Laravel values doğru, `DB_CONNECTION=sqlite`
  - **Happy path QA**: `cat .env.example | grep "DB_CONNECTION"` → `DB_CONNECTION=sqlite`, `cat .env.example | grep -c lerd` → 0
  - **Failure QA**: `.env.example` tüm gerekli env vars'ları içeriyor (APP_KEY hariç — onu artisan generate eder)
  - **Commit**: `chore: clean .env.example for standalone starter kit`

### Wave 5: Installer & Chisel Setup

- [ ] 8. `rename_livewire_files.php`'yi starter kit'e ekle (eğer Chisel kullanıyorsa — Chisel, `.blade.php` dosyalarına `⚡` prefix ekler). Bu script `post-create-project-cmd`'de çalışır, blade dosyalarını yeniden adlandırır, `chisel-paths.php`'yi günceller, sonra kendini composer.json'dan ve diskten siler. Script'i `laravel/livewire-starter-kit`'den al ve daisyUI-specific path'leri güncellemek için test et (eğer Chisel kullanmıyorsan bu todo'yu skip et).
  - **References**: `laravel/livewire-starter-kit/rename_livewire_files.php` (github.com/laravel/livewire-starter-kit/blob/main/rename_livewire_files.php), `laravel/chisel` package
  - **Acceptance criteria**: `rename_livewire_files.php` mevcut, `composer.json` `post-create-project-cmd`'de `@php rename_livewire_files.php` var, script daisyUI view path'lerini doğru hedefliyor
  - **Happy path QA**: `php rename_livewire_files.php` dry-run (eğer dry-run destekliyorsa), dosya isimleri doğru
  - **Failure QA**: Script diskten silinir (post-install), composer.json'dan kendi satırını kaldırır
  - **Commit**: `feat(installer): add rename_livewire_files for Chisel integration`

- [ ] 9. `chisel-paths.php` ve `chisel.php`'yi starter kit'e ekle — Bu dosyalar Chisel'ın hangi view dosyalarını yeniden adlandıracağını ve hangi feature'ları sunacağını tanımlar. daisyUI-specific view path'lerini (layouts/app/sidebar, layouts/auth/split, pages/auth/login, pages/settings/profile vb.) Chisel formatında tanımla.
  - **References**: `laravel/livewire-starter-kit/chisel-paths.php` (github.com/laravel/livewire-starter-kit/blob/main/chisel-paths.php), `laravel/livewire-starter-kit/chisel.php` (github.com/laravel/livewire-starter-kit/blob/main/chisel.php), `laravel/chisel` docs
  - **Acceptance criteria**: `chisel-paths.php` mevcut ve daisyUI view path'lerini içeriyor, `chisel.php` mevcut ve feature selection UI'ı tanımlıyor
  - **Happy path QA**: `php artisan list | grep install:features` → command mevcut
  - **Failure QA**: Chisel feature selection `laravel new` sırasında çalışır
  - **Commit**: `feat(chisel): add daisyui-specific chisel paths and features`

- [ ] 10. `app/Console/Commands/InstallFeaturesCommand.php`'yi ekle (eğer Chisel kullanıyorsa) — Bu command `post-create-project-cmd`'de çalışır, `chisel.php`'yi yükler, interaktif feature selection sunar, node deps kurar ve asset build eder. `LARAVEL_INSTALLER_DEFER_HOOKS` kontrolü ile installer altında deferred çalışır.
  - **References**: `laravel/livewire-starter-kit/app/Console/Commands/InstallFeaturesCommand.php` (github.com/laravel/livewire-starter-kit/blob/main/app/Console/Commands/InstallFeaturesCommand.php), Laravel installer deferral mekanizması (installer/src/NewCommand.php#L684-696)
  - **Acceptance criteria**: `InstallFeaturesCommand.php` mevcut, `shouldDeferInstallerHooks()` methodu var, `LARAVEL_INSTALLER_DEFER_HOOKS` kontrolü var
  - **Happy path QA**: `php artisan install:features --help` → command çalışır
  - **Failure QA**: Installer altında deferred çalışır (no double-execution)
  - **Commit**: `feat(installer): add InstallFeaturesCommand for Chisel`

### Wave 6: Final Cleanup & Validation

- [ ] 11. Tüm view'ları ve component'ları daisyUI semantic token'larla doğrula — `grep` ile hardcoded renk kontrolü: `text-white`, `text-black`, `bg-white`, `bg-black` (logo icon hariç — `text-white dark:text-black` kabul edilebilir). `welcome.blade.php` hariç tutulur (branded). Mevcut `.ai/rules/` dizinindeki kuralları koru (eğer starter kit'e dahil ediliyorsa).
  - **References**: Mevcut daisyUI migration çalışması (feat/daisyui-migration branch), AGENTS.md'deki daisyUI kuralları
  - **Acceptance criteria**: `grep -r "text-white\|text-black\|bg-white\|bg-black" resources/views/ --include="*.php" | grep -v "welcome\|logo-icon\|text-white dark:text-black\|text-black dark:text-white"` → sonuç yok (sadece logo icon pair'ları kalır)
  - **Happy path QA**: Tüm view'lar daisyUI semantic token kullanıyor, dark mode desteği tam
  - **Failure QA**: welcome.blade.php'deki branded renkler korunmuş
  - **Commit**: `chore: verify daisyui semantic tokens across all views`

- [ ] 12. Final validation — `composer install`, `npm install`, `npm run build`, `php artisan test --compact`, `vendor/bin/pint --test`, `vendor/bin/phpstan analyse` sırasıyla çalıştır ve hepsinin pass olduğunu doğrula. Yeni temiz repo'da sıfırdan kurulum testi.
  - **References**: Mevcut `composer.json` scripts (setup, test, lint, types:check), `phpstan.neon` config
  - **Acceptance criteria**: `composer install` → pass, `npm install` → pass, `npm run build` → pass, `php artisan test --compact` → pass (tüm testler), `vendor/bin/pint --test` → pass (0 dirty), `vendor/bin/phpstan analyse` → pass (0 errors)
  - **Happy path QA**: Temiz repo'dan sıfırf install → test → build → pass
  - **Failure QA**: Hiçbir test fail etmez, hiçbir pint/phpstan hatası yok
  - **Commit**: `chore: final validation pass`

## Final verification wave

- [ ] F1. Packagist readiness — `composer.json` doğrulama: `composer validate --strict` pass, `type: project`, `name: yellow-three/daisyui-starter-kit`, `license: MIT`, `extra.laravel.installer.post-create-project` mevcut, tüm dev-only dosyalar `export-ignore` ile işaretli, `.gitattributes` doğru
  - **Happy path**: `composer validate --strict` → "Valid" output
  - **Failure**: Invalid composer.json → Packagist reject

- [ ] F2. Clean install test — Sıfır bir dizinde `composer create-project yellow-three/daisyui-starter-kit test-app --stability=dev` çalıştır, npm install && npm run build, php artisan test --compact, tüm testlerin pass olduğunu doğrula
  - **Happy path**: Tüm testler pass, uygulama `http://localhost:8000` üzerinde çalışır
  - **Failure**: Bir test fail → starter kit'te eksik dosya veya yanlış config

- [ ] F3. Auth flow QA — Playwright ile: register → login → dashboard → settings/profile → settings/appearance (dark/light toggle) → settings/security → logout akışını otomatik test et
  - **Happy path**: Tüm sayfalar yüklenir, form'lar submit edilir, dark/light toggle çalışır
  - **Failure**: Bir sayfa 404/500 → eksik route veya view

- [ ] F4. No project-specific leakage — `grep -r "lerd\|fresh\.localhost\|boost\|laravel/boost" --include="*.php" --include="*.json" --include="*.js" --include="*.css" --include="*.md"` → sonuç yok (README hariç, orada "lerd" referansı olmamalı)
  - **Happy path**: Sıfır matches
  - **Failure**: Bir match → starter kit'te lerd-specific bilgi kalmış

- [ ] F5. README accuracy — `laravel new --using=yellow-three/daisyui-starter-kit` komutu README'de doğru, tech stack listesi güncel, personalizasyon talimatları anlaşılır
  - **Happy path**: README'deki tüm komutlar çalışır, tüm link'ler geçerli
  - **Failure**: Eski veya yanlış bilgi → kullanıcı yanıltılır

## Commit strategy
Her todo kendi commit'ini alır (yukarıda her todo'da `Commit:` satırında tanımlı). Wave'ler halinde ilerler: Wave 1 (repo) → Wave 2 (composer) → Wave 3 (package & cleanup) → Wave 4 (docs & env) → Wave 5 (installer) → Wave 6 (validation) → Final verification.

## Success criteria
1. `composer create-project yellow-three/daisyui-starter-kit test-app --stability=dev` temiz kurulum yapar
2. Tüm Pest testleri pass olur
3. Login → Dashboard → Settings → Logout akışı çalışır
4. Dark/light mode toggle çalışır
5. `vendor/bin/pint --test` ve `vendor/bin/phpstan analyse` pass olur
6. Packagist'e publish edilebilir (composer validate --strict pass)
7. Starter kit'te lerd/project-specific bilgi kalmamış
