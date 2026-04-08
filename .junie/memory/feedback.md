[2026-04-07 22:16] - Updated by Junie
{
    "TYPE": "correction",
    "CATEGORY": "API key config",
    "EXPECTATION": "The AI integration should read OPENAI_API_KEY via a config file (not env directly) so the provider receives a valid key and avoids 401 errors.",
    "NEW INSTRUCTION": "WHEN needing API keys or secrets THEN read from config files, not env directly"
}

[2026-04-07 22:19] - Updated by Junie
{
    "TYPE": "correction",
    "CATEGORY": "Tools payload format",
    "EXPECTATION": "The AI request must format the tools field as provider-expected objects to avoid 400 errors.",
    "NEW INSTRUCTION": "WHEN enabling AI tools/functions THEN format tools as provider-compliant objects, not arrays"
}

[2026-04-07 22:21] - Updated by Junie
{
    "TYPE": "correction",
    "CATEGORY": "Structured output schema",
    "EXPECTATION": "The AI response_format schema must be provider-compliant; 'required' should be defined at the object level to avoid 400 errors.",
    "NEW INSTRUCTION": "WHEN using HasStructuredOutput THEN place required fields at object level only"
}

[2026-04-07 22:43] - Updated by Junie
{
    "TYPE": "correction",
    "CATEGORY": "UI no-refresh behavior",
    "EXPECTATION": "When clicking Generate, keep the button as 'Gerando...' and persist the 'Gerando post...' block without refreshing the page.",
    "NEW INSTRUCTION": "WHEN user submits YouTube generate form THEN submit via AJAX and keep loading state"
}

