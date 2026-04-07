Project stack:

Laravel 13
TailwindCSS
Pest
PostgreSQL
pgvector

Architecture:

DTO
Tasks
Processes
Service classes

Guidelines:

Controllers must be thin.
Use FormRequest validation.
Update FormRequest must extend CreateFormRequest.
Prefer Eloquent over raw queries.
Always write Pest tests.
