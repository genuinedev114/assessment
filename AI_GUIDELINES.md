# AI Usage Guidelines (Developer Assessment)

## Purpose
This assessment is designed to evaluate **your personal engineering skills**: problem solving, coding ability, debugging, communication, and decision-making. To keep the results fair and comparable across candidates, **AI-assisted code generation is not allowed** for this assessment.

If anything in this document is unclear, use the “Questions” section at the end to contact us **before** proceeding.

---

## Rules Summary (What You Must Do)
- ✅ You may use official documentation and normal web resources.
- ✅ You may use your IDE/editor features that do not generate code (linting, formatting, autocomplete based on local symbols is OK).
- ❌ You may **not** use AI tools to generate, rewrite, transform, or suggest code or tests.
- ❌ You may **not** use AI tools to explain errors and then apply AI-proposed fixes.

---

## Prohibited AI Assistance (Not Allowed)
During this assessment, you must **not** use any AI system that provides code suggestions or code generation, including but not limited to:

- GitHub Copilot (and Copilot Chat)
- ChatGPT / OpenAI / Claude / Gemini / Perplexity
- Cursor, Windsurf, Codeium, Tabnine, Replit AI, Amazon Q, JetBrains AI Assistant, Sourcegraph Cody
- Any browser extension or IDE plugin that generates code, tests, comments, or refactors
- “Paste code, get an answer” tools (even if you write it into the editor yourself)

### Specific actions that are not allowed
- Generating or completing functions/classes/components with AI
- Generating tests, mocks, fixtures, or snapshots with AI
- Asking AI to debug an error and applying the fix it suggests
- Asking AI to write regex, SQL, shell commands, config files, CI workflows, Dockerfiles, etc.
- Asking AI to refactor, “clean up,” or “optimize” your code
- Using AI to write commit messages if they describe work you did not independently decide and implement

---

## Allowed Resources (Allowed)
You may use:
- Official language/framework documentation (e.g., MDN, PHP docs, Laravel docs)
- Package documentation and READMEs
- Man pages / built-in help (`--help`)
- Stack Overflow / blog posts / GitHub issues for reference
- Linters, formatters, and compilers
- Local IDE navigation tools (go to definition, find references, rename symbol)
- Non-AI autocomplete based on local/project symbols (basic IntelliSense)

If you’re unsure whether something counts as “AI-generated,” assume it is and do not use it.

---

## Required Editor / Environment Settings
Before starting, you must disable AI features:

### Required
- Disable any AI code assistants in your editor/IDE (Copilot, JetBrains AI, Cursor, etc.)
- Disable AI-enabled browser extensions that can generate or rewrite code
- Disable “AI terminal” features (if your terminal app offers them)

### You must not use “ghost text” suggestions
If your editor is showing predictive multi-line suggestions that are not from the project’s language server / symbols, **turn them off**.

---

## Verification & Integrity
We use a combination of methods to ensure fairness. These may include:
- Reviewing commit history and development pacing
- Checking for stylistic and structural inconsistencies typical of generated code
- Asking follow-up questions about design and implementation details
- Running a brief screen share or live walk-through (if needed)

If we believe AI assistance was used, we may:
- Ask you to re-do the assessment under supervised conditions, **or**
- Disqualify the submission

---

## What We *Do* Want to See
- Your approach to solving the problem
- Clear tradeoffs and reasoning
- Clean, maintainable code
- Meaningful tests (when requested)
- Honest notes about what you’d improve with more time

We value clarity and correctness over “cleverness.”

---

## If You Accidentally Use AI
If you realize you used an AI feature by mistake (e.g., it was enabled automatically):
1. Stop immediately
2. Document what happened in `SUBMISSION_NOTES.md`
3. Revert the affected changes and re-implement without AI help

We’d much rather see transparency than a perfect-looking submission.

---

## Questions
If you have any questions about these guidelines or what is permitted, contact us at:
- **Email:** tommy@modernmcguire.com

Do not proceed until you receive clarification.
