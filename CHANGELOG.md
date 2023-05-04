# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.5](https://github.com/ecphp/eu-login-api-authentication-bundle/compare/1.0.4...1.0.5)

### Commits

- refactor: remove custom services names. Use class FQDN instead. [`e0b6938`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/e0b69388e7536d997816951718f7b3c1267fb1ec)

## [1.0.4](https://github.com/ecphp/eu-login-api-authentication-bundle/compare/1.0.3...1.0.4) - 2023-04-25

### Merged

- add user provider back [`#49`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/49)
- chore(deps): Bump actions/stale from 7 to 8 [`#48`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/48)
- chore(deps): Bump actions/checkout from 2.3.4 to 3.4.0 [`#47`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/47)
- chore(deps): Bump actions/stale from 5 to 7 [`#38`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/38)
- chore(deps-dev): Update psalm/plugin-symfony requirement from ^4.0 to ^5.0 [`#37`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/37)
- chore(deps-dev): Update psalm/plugin-symfony requirement from ^3.1 to ^4.0 [`#36`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/36)
- chore(deps): Bump actions/cache from 3.0.5 to 3.0.11 [`#35`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/35)
- chore(deps): Bump actions/cache from 3.0.2 to 3.0.5 [`#26`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/26)
- chore(deps): Update facile-it/php-openid-client requirement from ^0.2 to ^0.3 [`#24`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/24)
- chore(deps): Bump actions/stale from 4 to 5 [`#20`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/20)
- chore(deps): Bump actions/cache from 3.0.1 to 3.0.2 [`#21`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/21)
- Symfony 5.4 and 6 upgrade [`#13`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/13)
- chore(deps): Update firebase/php-jwt requirement from ^5.2 to ^6.1 [`#18`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/18)
- chore(deps): Bump actions/cache from 2.1.7 to 3.0.1 [`#19`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/19)
- chore(deps): Update web-token/jwt-signature-algorithm-ecdsa requirement from ^2.2 to ^3.0 [`#16`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/16)
- chore(deps): Update web-token/jwt-signature-algorithm-hmac requirement from ^2.2 to ^3.0 [`#15`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/15)

### Commits

- docs: Update changelog. [`c70bae1`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c70bae105185bfcb3e0eebc936da75da7ed5f6d0)
- remove static keyword [`d8697bf`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/d8697bfbb976a8e0d638c6b99ea2bc0c401e07af)
- ci: add `PHP_CS_FIXER_IGNORE_ENV` [`2771d8f`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/2771d8f334f8d1be6c4fbf181c855b0c8809bf01)
- fix: relax `symfony/http-client` dependency [`a20d6f3`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/a20d6f3373ce41f4b330e05c34fe997ca3e493dd)
- tests: fix behat tests [`c1acc94`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c1acc94be1e0f2e94d1c08869599714afc024027)
- fix: add missing `@extends` annotation [`2a27198`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/2a271980b6e1ffc5f34e6d3afd8c8cb44802f36f)
- style: autofix code style with `prettier` [`ff75d54`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/ff75d547413aaf2a04668049f569f1aa4d0eeb35)
- chore: update LICENSER [`f215e1a`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/f215e1abcc15c34b10406c0a7aad5c2ab2a8c69d)
- fix: Fix badges [`dc4692a`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/dc4692a69499bc4731cbaf9e20f7f4dcfb3a4942)
- chore: update composer.json [`3e2e59e`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/3e2e59e5b24e7dd8c091b8f969bbee07fbcb3e4b)
- dev: update php environment [`2966daa`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/2966daab4eed1e5db0c4e6e79aae880ac92ac507)
- ci: update workflow [`d5ba972`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/d5ba972b43f418a48530129e14f5da907ed7618c)
- chore(deps-dev): Update psalm/plugin-symfony requirement [`4537ef4`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/4537ef4d758e354c38d52224edd3a39485af7559)
- chore(deps-dev): Update psalm/plugin-symfony requirement [`b04b371`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/b04b3712530000ecaba1d5bfcf6aabbbbb88ec81)
- cs: Autofix code style. [`86421f4`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/86421f4cad0bafb831b05c32fbb61a9bd27b7fbe)
- ci: Update Github action. [`9f5ab4c`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/9f5ab4c771a5a191403c02a2ed4798838f7e36cc)
- ci: Remove PHPInsights step. [`729f0aa`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/729f0aa6ad1c9fd546971a8bfef14d3c88bfa2b0)
- fix: Remove obsolete phpstan issue. [`55c4f55`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/55c4f55c24048aa930305bc39c052cbc7ca44610)
- chore: Update dev-dependencies version. [`00f6eaf`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/00f6eaf7fd17ba5466ecb3c326a7fcaadc607620)
- chore: Update firebase/php-jwt version. [`70e2e44`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/70e2e44675445bc2934265b1619e5f098fe4a1f7)
- fix: Add PSalm baseline. [`c60f317`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c60f31742d62305eabf1d21cec68c57f8a5020d6)
- chore: Remove Docker stuff. [`84731e7`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/84731e7f5275aacc50d901190aa7b6edaf77007e)
- chore(deps): Update facile-it/php-openid-client requirement [`1e04ae6`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/1e04ae6f5941e896599fb25893d078933ac5ffb6)
- chore: Make sure it is compatible with PHP 7.4. [`61fd0b4`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/61fd0b4c3feff1779488f27d7b3ffc901df427e5)
- chore(deps): Update web-token/jwt-signature-algorithm-ecdsa requirement [`768c246`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/768c246936586e8662f1595b93e2a8684ecd77df)
- chore(deps): Update web-token/jwt-signature-algorithm-hmac requirement [`e46a396`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/e46a3963edae7f902b4db42508377350d866c822)
- ci: Tests on PHP 7.4 and 8.1. [`9017cf7`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/9017cf7210ffe7d36103c4253c369cd411fe7233)
- chore: Update psalm configuration. [`48e3ad0`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/48e3ad09b2ad9a0a3ecc7a34cb460e0af5d548e1)
- refactor: Rewrite bundle for Symfony 5.4 and 6.0. [`f54bb7d`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/f54bb7de806606164b3f5b1e2c786484fa367526)
- tests: Update for Symfony 6. [`61f02a5`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/61f02a5f4f818019a5c9382096cccb4c6114c3ec)
- docs: Update documentation accordingly. [`6a57802`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/6a57802702f9dd8a77970ac0eaf77da36d17297d)
- chore: Get rid of PHPSpec. [`cba6e5e`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/cba6e5e453fd08213b0d085a4e962b8b2f74e2ac)
- chore: Update `composer.json`. [`9f25c50`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/9f25c50dcb7a4863cbd0c190e4ea5c9ad5975afa)

## [1.0.3](https://github.com/ecphp/eu-login-api-authentication-bundle/compare/1.0.2...1.0.3) - 2022-02-02

### Merged

- chore(deps): Bump actions/cache from 2.1.6 to 2.1.7 [`#10`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/10)
- chore(deps-dev): Update infection/infection requirement from ^0.23.0 to ^0.24.0 [`#9`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/9)
- chore(deps): Bump actions/stale from 3.0.18 to 4 [`#8`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/8)

### Commits

- docs: Update changelog. [`f9dc26e`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/f9dc26e043966ac30b1aa484b6d0c37f062d3e95)
- fix: Use `scalarNode` instead of `enumNode`. [`6fdcaca`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/6fdcaca485df4f1e12a763143c3044025fab7d73)
- chore: Update licence holder. [`178d01f`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/178d01f8369bddfcf5632a55e83a70daed7d713c)
- chore: Normalize `composer.json`. [`d6860ba`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/d6860bac3d3e5ae1124b60b0552a15d040d9ad89)
- chore(deps-dev): Update infection/infection requirement [`10af3ae`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/10af3ae6b681d83399a2b1816c402fc21234a5f6)
- Revert "ci: Disable tests on Darwin platform." [`86ef9aa`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/86ef9aa273ae436d28b669b862ce9492e64a872f)

## [1.0.2](https://github.com/ecphp/eu-login-api-authentication-bundle/compare/1.0.1...1.0.2) - 2021-07-05

### Commits

- docs: Add/update CHANGELOG. [`62eb313`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/62eb313a7e2c865887033e9874d8520766783bc3)
- chore: Update .gitattributes. [`048b625`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/048b6250b8375db42facff411bdf334b25f9c4f6)

## [1.0.1](https://github.com/ecphp/eu-login-api-authentication-bundle/compare/1.0.0...1.0.1) - 2021-06-09

### Merged

- chore(deps): Bump actions/cache from 2.1.5 to 2.1.6 [`#7`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/7)
- chore(deps-dev): Update infection/infection requirement from ^0.22.0 to ^0.23.0 [`#5`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/5)

### Commits

- doc: Update Changelog. [`7c6aaf5`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/7c6aaf5e81f839692b0f153fdf595fe1a653580a)
- ci: Disable tests on Darwin platform. [`b83aa47`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/b83aa477bebe7e4293246e19c8a3dca54af092a4)
- chore: Update composer.json. [`16d29d2`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/16d29d2db65568c5a9e3ed8c9d3c3f23f79dcf8a)
- refactor: Update code style. [`f81ecf4`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/f81ecf4a6e4368064d7df5d81ad685a42184197b)
- Autofix code style. [`758ccf2`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/758ccf2eaa6d34896ac8587afa9aa5bca1b9679a)
- test: Fix tests. [`9b41bf4`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/9b41bf48aa3909b5c51e45e3b32101de93085ab7)
- refactor: Update services, add missing wirings. [`4fdbb41`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/4fdbb415ad1e67cffbcff66a785482f576d99f6b)
- chore: Remove ajgarlag/psr-http-message-bundle. [`c90f7d7`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c90f7d75db5370599847d262d220894ec575e62e)
- chore(deps-dev): Update infection/infection requirement [`c1f471a`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c1f471af3c6e92efd934287916fbf3a6aae9cae5)
- refactor: Autofix code style. [`c8b434d`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c8b434dcdcde6756df5b0b73218e77d322e8f954)
- chore: Switch to ecphp/php-conventions. [`1bbdc21`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/1bbdc216affa8177bd86ee40e06a72f7b89abd2e)
- docs: Update links. [`2d8f82f`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/2d8f82f2740c8afd60352544df9e94ec31d5c172)

## 1.0.0 - 2021-04-28

### Merged

- chore(deps): Bump actions/cache from v2.1.4 to v2.1.5 [`#1`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/1)
- Create `LocalEuLoginApiCredentials` service that can be used for testing [`#3`](https://github.com/ecphp/eu-login-api-authentication-bundle/pull/3)

### Commits

- docs: Update changelog. [`7b6caef`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/7b6caefa14dbe7085de5714fb1465647d782d70c)
- ci: Enable automatic release changelog generation. [`17edfed`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/17edfedc7e47e47ba95e7d2da52933d2fb4cc092)
- docs: Update changelog. [`a1908d8`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/a1908d8bdfadb113921300c28a58524ffb27328e)
- docs: Update README and documentation accordingly. [`4273dd8`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/4273dd8f1c2dcf8efcde0ca77f0826d6a8f9e862)
- docs: Add documentation. [`9c16d86`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/9c16d8654a33ea80909b9c09da4c8abce50990a5)
- Let's be eco-friendly when it comes to package management. [`f4366d5`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/f4366d55ab6a9f1311d129ba324cfb7e5fb1710c)
- Disable Infection tests. [`51d8738`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/51d873877e2f508dd6770059086a2370be017b89)
- ci: Enable Behat tests. [`6d1511c`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/6d1511c5fee4d6e3aef246a6c12d37acd53bc86d)
- Normalize composer.json [`16afdb5`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/16afdb525e967e3c094d7d43068cbb78a777ebbb)
- Add Behat tests and features. [`528be25`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/528be25bc1f7ededba6db20f3546c9740b8f65af)
- refactor: Add a LocalEuLoginApiCredentials service to be used for testing. [`077f078`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/077f0787b0f46b5ddab81a5fc1a2fef490118d54)
- Add token route to the bundle. [`4b32fdc`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/4b32fdc840bf93886be604a46ff34d6a13aca9c5)
- chore: Add Docker stack for Changelog generation. [`e8a662b`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/e8a662b922c51a4457bb4c687b10211f81c74f3e)
- refactor: Update code style based on drupol/php-conventions. [`7f71738`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/7f71738065dba8be393b2eab2c420e028d4c3c01)
- refactor: Upgrade to drupol/php-conventions version 4. [`84f9e23`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/84f9e23ad76002493be6c1a258cf3bbeb02455e0)
- refactor: Return the user in UserProvider::refreshUser(). [`4430bc7`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/4430bc743d1f0e60cc2a263b91e4bcb9477dff27)
- chore: Update composer.json. [`f2af671`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/f2af671a31544c5be38ad215947aa5fd681de32d)
- docs: Add comments and fix typo. [`c54ad25`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/c54ad252b9489765ed3d40ee9640b14b93e296a4)
- fix: Handle controllers automatically. [`adf4aa4`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/adf4aa439f23adf8944ce2f9f4fb82839bf5db27)
- docs: Update README. [`427a91d`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/427a91db5f09e1c83e08eeb0a39f8ab47f5ea5a7)
- tests: Add initial tests. [`6e742db`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/6e742db1f9bc0ee86d242e727cb387e7c6c64e60)
- refactor: Use custom exceptions. [`098513d`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/098513d0f5756b984db470dd042d3a7a63f0a351)
- refactor: Add custom exceptions. [`a777615`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/a777615761a14c30dcefddfd28aa8a2de69e5b79)
- Initial set of files. [`fb7edd1`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/fb7edd19666a07e91dd3b211c12f41c8cac42cf8)
- Initial commit. [`908ffa9`](https://github.com/ecphp/eu-login-api-authentication-bundle/commit/908ffa9a9e8cc59bb43cd3fb327c849229647599)
