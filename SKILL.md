---
name: debug-controller-generator
description: Create a debug controller for investigating a Laravel app — querying Eloquent models, generating reports, exporting data, inspecting logs, etc. Registers its route and, if the gen-http skill is available, generates a .http file to test it.
metadata:
  author: amdlemos
  version: "2.0.0"
  argument-hint: <ControllerName>
---

# Debug Controller Generator

Scaffolds a debug controller under `app/Http/Controllers/Debug/` and registers its route in `routes/api.php`. The controller is a starting point for ad-hoc investigation work — querying Eloquent models, building reports, exporting data, digging through logs — not a fixed-purpose endpoint, so the scaffold stays minimal and the dev fills in the actual logic afterwards.

There is no script here: perform every step below yourself with your normal file tools.

## Step-by-step process

### 1. Resolve the controller name

Take the name from the user's request (e.g. `DebugMyThingController`). If they didn't give one, ask for it. Keep the `Debug` prefix convention if that's what the project already uses for this folder.

Derive the route slug from the name: strip a trailing `Controller`, convert to kebab-case (`DebugMyThingController` → `my-thing`).

### 2. Create the controller file

Target path: `app/Http/Controllers/Debug/<ControllerName>.php`.

- If the file already exists, stop and tell the user — never overwrite an existing controller.
- Otherwise, use `controller_template.php` (in this skill's directory) as the base, replacing `__CONTROLLER_NAME__` with the actual class name. It scaffolds an invokable controller that validates the request via `$request->validate([...])`, following standard Laravel conventions:

```php
<?php

namespace App\Http\Controllers\Debug;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DebugMyThingController
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            //
        ]);

        return response()->json(['success' => true, 'data' => $validated]);
    }
}
```

### 3. Register the route

Open `routes/api.php` and find the existing debug routes area (typically a group with prefix `admin/debug`, or a cluster of routes already using `App\Http\Controllers\Debug\...`). Match the project's existing style rather than assuming one fixed shape.

- Add `use App\Http\Controllers\Debug\<ControllerName>;` near the other Debug imports if it isn't there yet.
- Add the route near the other debug routes:
  ```php
  Route::get('admin/debug/<kebab-slug>', [<ControllerName>::class, '__invoke']);
  ```
- If a group already wraps `admin/debug` with the array-callable shorthand or a different HTTP verb pattern, follow that pattern instead of forcing this exact line.

### 4. Generate a .http test file — via the gen-http skill

Once the controller and route exist, check whether the `gen-http` skill is available (it will be listed among your available skills). If it is, invoke it for the controller you just created so the dev gets a ready-to-use `.http` request for the new endpoint.

If `gen-http` is not available, skip this step entirely — don't hand-write a `.http` file as a substitute, and don't create any other documentation file in its place.

### 5. Suggest a commit — don't commit automatically

This skill never runs `git commit`. After the files are in place, suggest a semantic commit message in Portuguese and let the user review and run it themselves, e.g.:

```
chore(debug): adicionar controller <ControllerName> e rota /admin/debug/<kebab-slug>
```

```bash
git add app/Http/Controllers/Debug/<ControllerName>.php routes/api.php
git commit -m "chore(debug): adicionar controller <ControllerName> e rota /admin/debug/<kebab-slug>"
```
