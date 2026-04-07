As an AI agent, you must follow these rules strictly when working on this project.

## Core Principles
1. **Context & Business Rules:** Follow the stack and architecture defined in `.ai/context.md` and `.ai/guidelines.md`.
2. **Laravel Boost Tools:** Prefer MCP tools (`database-query`, `search-docs`, etc.) over manual shell commands.
3. **Architecture:** Use DTOs, Tasks, and Processes. Keep Controllers thin and use FormRequests.
4. **Testing:** Write Pest tests for every change. No exceptions.
5. **Code Style:** Use strict typing, constructor promotion, and run Pint (`vendor/bin/pint --dirty --format agent`) before finishing.
6. **Package Docs:** Always use `search-docs` before implementing features related to Laravel ecosystem packages.

Refer to `.ai/guidelines.md` for the full technical specification.
