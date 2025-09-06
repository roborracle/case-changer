# Deploy a specialized agent for a specific task

Deploy the appropriate agent based on the task type: $ARGUMENTS

## Available Agents

### Development & Implementation
- **backend-architect** - System design, API architecture, database design
- **backend-developer** - Laravel implementation, PHP development
- **frontend-developer** - UI implementation, JavaScript, Livewire components
- **devops-automator** - CI/CD, deployment, infrastructure

### Design & UX
- **ui-designer** - Visual design, component design, accessibility
- **ux-researcher** - User research, behavior analysis, usability testing

### Quality & Testing
- **test-writer-fixer** - Write and maintain tests, fix failing tests
- **tool-evaluator** - Evaluate libraries, tools, and technologies
- **task-checker** - Verify task completion and quality

### Task Management
- **task-orchestrator** - High-level planning and coordination
- **task-executor** - Execute specific implementation tasks

## Steps

1. Identify the type of task from: $ARGUMENTS
2. Select the most appropriate agent for the task
3. Deploy the agent with clear instructions
4. Have the agent complete the requested task

## Example Usage
- `/use-agent review the UI for accessibility issues` → Deploys ui-designer
- `/use-agent write tests for the converter` → Deploys test-writer-fixer
- `/use-agent evaluate using Redis for caching` → Deploys tool-evaluator