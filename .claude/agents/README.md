# Claude Code Agents for Case Changer Pro

This directory contains specialized agent personas that can be invoked within Claude Code to handle specific development tasks with focused expertise.

## Available Agents

### 🏗️ Engineering & Backend

#### **backend-architect** (`backend-architect.md`)
- **Purpose**: Designing APIs, building server-side logic, implementing databases, architecting scalable backend systems
- **Expertise**: RESTful APIs, GraphQL, database design, microservices, security implementation, performance optimization
- **Best for**: API design, database architecture, system scaling, authentication systems
- **Tech Stack**: Node.js, Python, Go, Java, PostgreSQL, MongoDB, Redis, AWS/GCP/Azure

#### **backend-developer** (`backend-developer.md`)
- **Purpose**: General backend development tasks and Laravel-specific implementation
- **Expertise**: PHP/Laravel backend development, server-side logic, API endpoints
- **Best for**: Laravel backend features, server-side implementation, PHP development

#### **devops-automator** (`devops-automator.md`)
- **Purpose**: Setting up CI/CD pipelines, configuring cloud infrastructure, implementing monitoring systems
- **Expertise**: Infrastructure as code, container orchestration, monitoring & observability, security automation
- **Best for**: Deployment automation, infrastructure setup, monitoring systems, CI/CD pipelines
- **Tech Stack**: GitHub Actions, Docker, Kubernetes, Terraform, AWS/GCP/Azure, Prometheus

#### **test-writer-fixer** (`test-writer-fixer.md`)
- **Purpose**: Writing comprehensive tests, running existing tests, analyzing failures, maintaining test suite integrity
- **Expertise**: Unit testing, integration testing, test automation, test maintenance, failure analysis
- **Best for**: Test creation, test debugging, test suite maintenance, coverage analysis
- **Frameworks**: Jest, Vitest, PHPUnit, Pytest, JUnit, XCTest

### 🎨 Design & User Experience

#### **ui-designer** (`ui-designer.md`)
- **Purpose**: Creating user interfaces, designing components, building design systems, improving visual aesthetics
- **Expertise**: Modern design trends, component systems, responsive design, accessibility, Tailwind CSS
- **Best for**: Interface design, design systems, visual hierarchy, mobile-first design, trend implementation
- **Tools**: Tailwind CSS, Figma, design tokens, component libraries

#### **ux-researcher** (`ux-researcher.md`)
- **Purpose**: Conducting user research, analyzing user behavior, creating journey maps, validating design decisions
- **Expertise**: User research methodologies, behavioral analysis, usability testing, persona development
- **Best for**: User research, journey mapping, usability testing, user persona creation, research synthesis
- **Methods**: User interviews, A/B testing, usability testing, analytics analysis

### 🧪 Testing & Quality Assurance

#### **tool-evaluator** (`tool-evaluator.md`)
- **Purpose**: Evaluating new development tools, frameworks, services, making technology recommendations
- **Expertise**: Tool assessment, comparative analysis, cost-benefit evaluation, integration testing
- **Best for**: Technology evaluation, tool comparison, adoption recommendations, stack decisions
- **Focus**: Development velocity, integration complexity, cost analysis, team readiness

### 📋 Task Management (Task Master Integration)

#### **task-orchestrator** (`task-orchestrator.md`)
- **Purpose**: High-level project coordination, task prioritization, workflow optimization
- **Expertise**: Project management, task coordination, milestone tracking, team coordination
- **Best for**: Project planning, task coordination, milestone management, workflow optimization

#### **task-executor** (`task-executor.md`)
- **Purpose**: Executing specific development tasks, implementation work, hands-on coding
- **Expertise**: Code implementation, feature development, bug fixes, direct execution
- **Best for**: Hands-on development, feature implementation, coding tasks, bug resolution

#### **task-checker** (`task-checker.md`)
- **Purpose**: Quality assurance, task validation, completion verification, standards compliance
- **Expertise**: Code review, quality checking, testing validation, standards enforcement
- **Best for**: Quality assurance, task validation, code review, compliance checking

### 👨‍💻 General Development

#### **frontend-developer** (`frontend-developer.md`)
- **Purpose**: Frontend development tasks, UI implementation, client-side functionality
- **Expertise**: Frontend frameworks, JavaScript/TypeScript, responsive design, client-side logic
- **Best for**: Frontend implementation, UI development, client-side features

## How to Use Agents

### In Claude Code
When working in Claude Code, you can invoke agents using the `@agent` syntax:

```
@ui-designer Help me redesign the settings page layout
@backend-architect Design a new API for user preferences
@test-writer-fixer Run tests and fix any failures after my changes
@devops-automator Set up CI/CD for this Laravel project
```

### Choosing the Right Agent

**For Backend Work:**
- Use `backend-architect` for system design and architecture decisions
- Use `backend-developer` for Laravel-specific implementation
- Use `devops-automator` for infrastructure and deployment

**For Frontend/Design:**
- Use `ui-designer` for visual design and component creation
- Use `ux-researcher` for user experience research and validation
- Use `frontend-developer` for implementation

**For Quality & Testing:**
- Use `test-writer-fixer` for comprehensive testing needs
- Use `tool-evaluator` for technology decisions
- Use `task-checker` for quality assurance

**For Project Management:**
- Use `task-orchestrator` for high-level coordination
- Use `task-executor` for hands-on implementation
- Use `task-checker` for validation and QA

## Agent Characteristics

Each agent comes with:
- **Specialized expertise** in their domain
- **Specific tools** they're configured to use
- **Focused workflow** optimized for their tasks
- **Domain knowledge** and best practices
- **Integration awareness** with the project stack

## Best Practices

1. **Choose the right agent** for the specific task type
2. **Be specific** about what you need the agent to accomplish
3. **Combine agents** for complex tasks spanning multiple domains
4. **Follow up** with task-checker agent for quality validation
5. **Use task-orchestrator** for coordinating multi-agent workflows

## Project Context

All agents are configured with knowledge of:
- Case Changer Pro Laravel application
- Current tech stack (Laravel, Livewire, Tailwind CSS)
- CSP (Content Security Policy) requirements
- Task Master AI integration
- Rapid development cycle preferences (6-day sprints)

## Notes

- Task Master agents (`task-orchestrator`, `task-executor`, `task-checker`) are project-specific
- Repository agents have been updated with comprehensive expertise
- All agents are configured for the rapid development philosophy
- Agents respect the existing project structure and coding standards