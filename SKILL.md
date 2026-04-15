---
name: debug-controller-generator
description: Create debug controllers, register routes and update admin endpoints documentation.
metadata:
  author: runy
  version: "1.0.0"
  argument-hint: <ControllerName>
---

# Debug Controller Generator

This skill scaffolds a debug controller under `app/Http/Controllers/Debug/`, appends an entry to `dev-docs/admin-endpoints.md`, and registers the route at the end of `routes/api.php` inside the existing debug routes block.

Usage:

1. Run the skills CLI with a controller name (for example `DebugMyThingController`):

```bash
npx skills run debug-controller-generator -- DebugMyThingController
```

2. What this skill will do:

- Create `app/Http/Controllers/Debug/<ControllerName>.php` with a simple invokable controller scaffold.
- Add a small documented endpoint entry to `dev-docs/admin-endpoints.md` under the Debug section.
- Register a route at the end of `routes/api.php` inside the Debug routes area (group prefix `admin/debug`), keeping the file imports organized.

Notes on editing:

- The skill will not overwrite an existing controller file; it will error if the file already exists.
- The skill will insert a route registration as a route using `Route::get('admin/debug/<kebab-name>', [\App\Http\Controllers\Debug\<ControllerName>::class, '__invoke']);` appended near other debug routes. If the Debug import block is missing it will add a `use App\Http\Controllers\Debug\<ControllerName>;` import at the top.

Implementation details:

- The skill should be implemented as a small shell script or the SKILL runner provided by `skills.sh`. It must perform safe edits (create file, append docs, append route) and print the three changed file paths when complete.

Example generated controller content (invokable):

```php
<?php

namespace App\Http\Controllers\Debug;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DebugMyThingController
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'message' => 'Debug endpoint active']);
    }
}
```

If you want me to create the controller now, reply with the controller name to generate (e.g. `DebugExampleController`).
