<!-- 0755de80-2814-4ea9-aaaa-ef4d68532623 d49e3954-818f-408c-9cee-bbdb3fe7d4b6 -->
# PLAN: Caller Package Agent Onboarding

### Purpose

Enable AI agents to quickly understand `0xKhdr/caller`, navigate the codebase, and implement safe, incremental features with tests.

### High-level Overview

- **Core roles**
    - **Caller**: defines request (method, URL, options) and designates a **Receiver**.
    - **CallService**: executes HTTP via Laravel Http and dispatches to Receiver.
    - **Receiver**: transforms `Response` → domain **DTO**. If extending `ResponseReceiver`, exposes `toResponse()` and `getStatus()`.
    - **DTO**: immutable, typed representation of response data.
- **Flow**: Controller/service → Caller::call() → CallService → Http → Receiver::fromResponse() → DTO.

### Key Files and Interfaces

- Callers
    - `src/raid/caller/src/Callers/Contracts/Caller.php`
    - `src/raid/caller/src/Callers/CallerAbstract.php`
    - HTTP method helpers: `GetCaller.php`, `PostCaller.php`, `PutCaller.php`, `PatchCaller.php`, `DeleteCaller.php`
- Receivers
    - `src/raid/caller/src/Receivers/Contracts/Receiver.php`
    - `src/raid/caller/src/Receivers/ReceiverAbstract.php`
    - `src/raid/caller/src/Receivers/ResponseReceiver.php`
- DTOs
    - `src/raid/caller/src/Dtos/Contracts/Dto.php`
    - `src/raid/caller/src/Dtos/DtoAbstract.php`
- Services
    - `src/raid/caller/src/Services/CallService.php` (request orchestration)
- Traits/Utilities
    - `src/raid/caller/src/Traits/*` (ToArray, ToLog, ToResponse, InteractsWithProvider)
- Laravel integration
    - `src/raid/caller/src/Providers/CallerServiceProvider.php`
- Demo usage
    - Callers: `src/app/Callers/**`

### Concept Model

- Callers encapsulate request intent and options; they do not parse.
- Receivers own parsing/validation and produce DTOs; with `ResponseReceiver` they expose `toResponse()` and `getStatus()`.
- DTOs are immutable value objects with `fromArray`, `has`, `get`, `toArray`.
- CallService centralizes HTTP, logging, retries/middleware via options.

### Request Lifecycle (Nominal)

1. Instantiate Caller with inputs (IDs, payloads, headers).
2. Caller exposes `getMethod()`, `getUrl()`, `getOptions()`, `getReceiver()`.
3. `Caller::call()` delegates to `CallService`.
4. HTTP executes with merged defaults → `Illuminate\Http\Client\Response`.
5. `Receiver::fromResponse($response)` builds Receiver with DTO + metadata.
6. Consumer uses `Receiver->toResponse()` and `getStatus()` when using `ResponseReceiver`.

### Conventions

- DTOs: read-only promoted properties; implement `fromArray(array $data): static`.
- Receivers: static `fromResponse(Response)`; never do network IO.
- Callers: no response parsing; compose options (headers, json, query, middleware).
- Logging: use ToLog/ToResponse traits where available; respect config flags.
- Errors: prefer Receiver methods and explicit exceptions at boundaries.

### Implementing a New Integration (Template)

1. Create DTO in app (or package) that models response JSON.
2. Create Receiver with `fromResponse(Response)` that returns `static` built with your DTO; set status and shape responses if using `ResponseReceiver`.
3. Create Caller (extend `CallerAbstract` or method-specific base like `GetCaller`, `PostCaller`). Implement `getUrl()`, optionally `getOptions()`, and `getReceiver(): string`.
4. Use Caller where needed (controller/service) and call `->call()`.
5. Add tests (Receiver unit test using Laravel HTTP fake).

### Minimal Example Snippets

- DTO skeleton:
```php
readonly class UserDto extends DtoAbstract {
    public function __construct(
        protected int $id,
        protected string $name,
    ) {}
    public static function fromArray(array $d): static { return new static(id: $d['id'], name: $d['name']); }
}
```

- Receiver skeleton:
```php
readonly class FindUserReceiver extends ResponseReceiver {
    public function __construct(
        protected int $status,
        protected UserDto $user,
    ) {}
    public static function fromResponse(Response $r): static {
        return new static(status: $r->status(), user: UserDto::fromArray($r->json()));
    }
    protected function toSuccessResponse(): array { return ['message' => 'User found successfully', 'data' => $this->user->toArray()]; }
    protected function toErrorResponse(): array { return ['message' => 'Failed to find user']; }
}
```

- Caller skeleton:
```php
readonly class FindUserCaller extends GetCaller {
    public function __construct(protected int $id) {}
    public static function make(int $id): static { return new static(id: $id); }
    public function getUrl(): string { return "https://api.example.com/users/{$this->id}"; }
    public function getOptions(): array { return ['headers' => ['Accept' => 'application/json']]; }
    public function getReceiver(): string { return FindUserReceiver::class; }
}
```

### Testing Guidance

- Use Laravel HTTP fakes to construct `Http::response(...)`, call `Receiver::fromResponse(...)`, and assert `getStatus()` and `toResponse()` payloads.

### Observability & Config

- Config defaults and logging toggles are documented in `docs/INTRODUCTION.md`.
- Respect `default_options` and per-caller overrides (timeouts, retries, middleware).

### Safety & Backwards Compatibility

- Keep Callers/Receivers stable contracts; prefer additive changes.
- Avoid breaking DTO shape; add new optional fields instead.

### Common Extension Points

- Add middleware/retry via caller `getOptions()`.
- Introduce composite DTOs for pagination/meta.
- Provide a generic `ResponseReceiver` when DTOs aren’t required yet.

### Suggested Roadmap Hooks (for agents)

- Add standardized error DTO and exception mapper.
- Provide rate-limit retry middleware example.
- Add per-caller circuit breaker option.
- Generate DTOs from OpenAPI as scaffolding.

### File Map (quick nav)

- Package: `src/raid/caller/src/**`
- Demo app Callers: `src/app/Callers/**`
- Docs: `src/raid/caller/docs/**`

### Acceptance Criteria for New Features

- New Caller/Receiver/DTO covered by unit+feature tests.
- No breaking interface changes; config-respecting; logging behind flag.
- Clear docs update with example usage.


