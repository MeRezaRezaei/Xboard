# AGENTS Instructions

## Mandatory
- Always read `docs/project_brain/ENTRYPOINT.md` first.
- Follow `docs/project_brain/OPERATING_PROTOCOL.md` for session flow.
- Use `docs/project_brain/BACKLOG.md` as the source of task priority.
- Do not finish a session without updating:
  - `docs/project_brain/SESSION_STATE.md`
  - `docs/project_brain/BACKLOG.md`
  - `docs/project_brain/CHANGELOG_AI.md`

## Single Source of Truth & Abstraction
- **Single Source of Truth**: The files under `docs/project_brain/` are the absolute and sole source of authority. Do NOT rely on unrecorded previous session memories or make assumptions not defined in the project brain.
- **Abstractions over Raw Details**: To prevent context details from being lost during context compression/truncation, write high-level abstractions (like human concepts/words) in the project brain rather than carrying raw chat history. 

## Management & Control Lifecycle
- **Goal Definition**: The user defines the goal (specifically targeting "the next pain in the ass problem").
- **AI Planning**: The AI must design the plan to achieve that goal. The exact path is flexible as long as the marginal result (the goal) is successfully reached.
- **Do**: Execute the plan.
- **Compare & Replan**: 
  1. Compare the real execution outcome with the plan.
  2. If the outcome diverges or fails, replan based on the comparison (or suggest goal shifts if needed).
  3. Log the entire cycle—goals, plans, actions, results, comparisons, and plan/goal shifts—in the project brain.

## Data Organization & Visuals
- **Standards & Templates**: Follow the data organization regulations defined in `docs/project_brain/DATA_ORGANIZATION.md`.
- **Mermaid Diagrams**: Maintain visual, human-scannable diagrams (Gantt, Flowcharts, Mindmaps, Ishikawa, Sequence) to explain complex logic. Use the reference syntax and styling rules located in the [Mermaid Cheat Sheet](ai-brain/Mermaid-Cheat-Sheet) submodule.
- **Mermaid Validation**: Always validate `.mmd` diagrams using `python ai-brain/scripts/validate_mermaid.py` whenever you modify them, to prevent broken charts from being saved.

## Project Context
- Fill and maintain `docs/project_brain/PROJECT_CONTEXT.md`.
- Respect runtime baseline in `docs/project_brain/ENVIRONMENT_BASELINE.md`.
- This is a Laravel/PHP VPN panel project. All commits go to `leonardo` remote.
- AI tooling scripts live in `tools/` (local only, not in git).
- Credentials are in `.env.ai` (local only, not in git).
- Start every session: `set -a; source .env.ai; set +a`

## MVP claims
- If MVP tracker is present, do not claim MVP complete until
  `docs/project_brain/MVP_CHECKLIST_TRACKER.md` required items are PASS.
