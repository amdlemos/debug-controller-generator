# Debug Controller Generator Skill

Skill to scaffold Laravel debug controllers for ad-hoc investigation — querying Eloquent models, generating reports, exporting data, inspecting logs — and register their routes.

There's no generator script: `SKILL.md` carries the full instructions for an agent to create the controller and register the route directly, using `controller_template.php` as the base. If the `gen-http` skill is available, it's invoked afterwards to scaffold a `.http` test file for the new endpoint.

Files:

- SKILL.md: skill metadata and step-by-step instructions
- controller_template.php: template for generated controllers

This repository is intended to be published (e.g. GitHub) so it can be installed via `npx skills add <owner>/debug-controller-generator`.
